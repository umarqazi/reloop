<?php


namespace App\Services\Admin;


use App\Repositories\Admin\AddressRepo;
use App\Repositories\Admin\OrganizationRepo;
use App\Repositories\Admin\UserRepo;
use App\Services\Admin\BaseService;
use App\Services\Admin\UserService;
use App\Services\ILoginType;
use App\Services\IUserStatus;
use App\Services\IUserType;
use App\Services\SectorService;
use App\Services\StripeService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Services\EmailNotificationService;
use Maatwebsite\Excel\Collections\RowCollection;
use Maatwebsite\Excel\Facades\Excel;

class OrganizationService extends BaseService
{

    private $organizationRepo;
    private $addressRepo;
    private $userService;
    /**
     * Property: emailNotificationService
     *
     * @var EmailNotificationService
     */
    private $emailNotificationService;
    /**
     * ProductService constructor.
     */

    public function __construct(UserService $userService,EmailNotificationService $emailNotificationService,AddressRepo $addressRepo)
    {
        $organizationRepo =  $this->getRepo(OrganizationRepo::class);
        $this->organizationRepo = new $organizationRepo;
        $this->addressRepo =  $addressRepo;
        $this->userService = $userService;
        $this->emailNotificationService = $emailNotificationService;
    }


    /**
     * @param array $data
     * @return bool
     */
    public function insert($request)
    {
        $organizationData = array(
            'org_external_id'   => 'ORG'.rand(000000,999999),
            'name'              => $request['name'],
            'no_of_employees'   => $request['no_of_employees'],
            'no_of_branches'    => $request['no_of_branches'],
            'sector_id'         => $request['sector_id'],
        );
        DB::beginTransaction();
        $organization = parent::create($organizationData);
        if ($organization) {
            $dataObject = (object) $request;
            $stripeCustomerId = App::make(StripeService::class)->createCustomer($dataObject);
            $userData = array(
                'organization_id' => $organization->id,
                'email'           => $request['email'],
                'stripe_customer_id' => $stripeCustomerId,
                'phone_number'    => $request['phone_number'],
                'password'        => Hash::make($request['password']),
                'status'          => IUserStatus::ACTIVE,
                'user_type'       => IUserType::ORGANIZATION,
                'login_type'      => ILoginType::APP_LOGIN,
                'api_token'       => str_random(50).strtotime('now'),
            );
            $user = $this->userService->create($userData);
            if ($user) {
                for ($i = 0; $i < sizeof($request['street']); $i++) {
                    $address = array(
                        'user_id'         => $user->id,
                        'type'            => $request['type'][$i],
                        'city_id'         => $request['city_id'][$i],
                        'district_id'     => $request['district_id'][$i],
                        'street'          => $request['street'][$i],
                        'floor'           => $request['floor'][$i],
                        'unit_number'     => $request['unit-number'][$i],
                        'location'        => $request['location'][$i],
                        'no_of_occupants' => $request['occupants'][$i],
                        'default'         => $i == 0 ? 1 : 0 ,
                    );
                    $this->addressRepo->create($address);
                }
                DB::commit();
                $this->emailNotificationService->adminOrganizationCreateEmail($userData);
                return true;
            } else {
                DB::rollBack();
                return false;
            }
        } else {
            DB::rollBack();
            return false;
        }
    }

    /**
     * Method: import
     * Import organizations from the CSV file.
     *
     * @param $request
     *
     * @return void
     */
    public function import($request): void
    {
        $path = $request->file('importFile')->getRealPath();

        /* @var RowCollection $organizations*/
        $organizations = Excel::load($path)->get();

        if($organizations->count() > 0) {
            // Get heading
            $heading = $organizations->getHeading();

            if ($this->importValidate($heading)) {
                // Get all sectors
                $sectors = App::make(SectorService::class)->getAll();
                $cities = App::make(\App\Services\CityService::class)->getAll();
                $districts = App::make(\App\Services\DistrictService::class)->getAll();

                foreach ($organizations as $org) {
                    // Get sector
                    if (!empty($org['sector'])) {
                        $sector = $sectors->first(
                            static function ($sector, $key) use ($org) {
                                return $sector->name === $org['sector'];
                            }
                        );
                    }

                    DB::beginTransaction();

                    $organizationData = array(
                        'name' => $org['name'],
                        'no_of_employees' => $org['number_of_employees'],
                        'no_of_branches' => $org['number_of_branches'],
                        'sector_id' => $sector ? $sector->id : null,
                        'org_external_id' => 'ORG'.rand(000000,999999)
                    );
                    $organization = $this->create($organizationData);

                    if ($organization) {
                        $userData = array(
                            'organization_id' => $organization->id,
                            'email' => $org['email'],
                            'phone_number' => $org['phone_number'],
                            'password' => ($org['password'] ?? Hash::make('12345678')),
                            'status' => IUserStatus::ACTIVE,
                            'user_type' => IUserType::ORGANIZATION,
                            'login_type' => ILoginType::APP_LOGIN,
                            'api_token' => str_random(50).strtotime('now'),
                        );
                        $user = $this->userService->create($userData);

                        $city = $cities->first(
                            static function ($city, $key) use ($org) {
                                return $city->name === $org['city'];
                            }
                        );

                        $district = $districts->first(
                            static function ($district, $key) use ($org) {
                                return $district->name === $org['district'];
                            }
                        );

                        $address = array(
                            'user_id' => $user->id,
                            'type' => (!empty($org['type']) ? $org['type'] : ''),
                            'city_id' => (!empty($city) ? $city->id : null),
                            'district_id' => (!empty($district) ? $district->id : null),
                            'street' => $org['street'],
                            'floor' => $org['floor'],
                            'unit_number' => $org['unit_number'],
                            'location' => $org['location'],
                            'no_of_occupants' => $org['no_of_occupants'],
                            'default' => true,
                        );
                        $this->addressRepo->create($address);
                        DB::commit();
                    }
                }
            }
        }
    }

    private function importValidate(array $data)
    {
        return in_array('name', $data)
            && in_array('number_of_employees', $data)
            && in_array('email', $data)
            && in_array('phone_number', $data)
            && in_array('city', $data)
            && in_array('district', $data)
            && in_array('street', $data)
            && in_array('floor', $data)
            && in_array('unit_number', $data)
            && in_array('location', $data)
            && in_array('no_of_occupants', $data);
    }

    /**
     * @param array $data
     * @param  int $id
     * @return bool
     */
    public function upgrade($id, $request)
    {
        $organizationData = array(
            'name'            => $request['name'],
            'no_of_employees' => $request['no_of_employees'],
            'no_of_branches'  => $request['no_of_branches'],
            'sector_id'       => $request['sector_id'],
        );
        DB::beginTransaction();
        $organization = parent::update($id, $organizationData);
        if ($organization) {
            $users = $this->findById($id)->users;
            $user_id = $users[0]->id;
            $userData = array(
                'email'        => $request['email'],
                'phone_number' => $request['phone_number'],
                'status'       => $request['status'],
            );
            if($request['status'] == 1){
                $userData = $userData + ['verified_at' => Carbon::now()];
            }
            $user = $this->userService->update($user_id, $userData);
            if ($user) {
                $old_ids = array();
                foreach ($users[0]->addresses as $address) {
                    $old_ids[] += $address->id;
                }
                if ($request->has('address-id')) {
                    $difference = array_diff($old_ids, $request['address-id']);
                } else {
                    $difference = $old_ids;
                }
                if ($request->has('street')) {
                    if (sizeof($difference) > 0) {
                        foreach ($difference as $key => $diff) {
                            $this->addressRepo->destroy($diff);
                        }
                        for ($i = 0; $i < sizeof($request['street']); $i++) {
                            $address = array(
                                'type'            => $request['type'][$i],
                                'city_id'         => $request['city_id'][$i],
                                'district_id'     => $request['district_id'][$i],
                                'street'          => $request['street'][$i],
                                'building_name'   => $request['building_name'][$i],
                                'floor'           => $request['floor'][$i],
                                'unit_number'     => $request['unit-number'][$i],
                                'location'        => $request['location'][$i],
                                'no_of_occupants' => $request['occupants'][$i],
                            );
                            if (array_key_exists($i, $request['address-id'])) {
                                $this->addressRepo->update($request['address-id'][$i], $address);
                            } else {
                                $address['user_id'] = $user_id;
                                $this->addressRepo->create($address);
                            }
                        }
                        DB::commit();
                        return true;
                    } else {
                        for ($i = 0; $i < sizeof($request['street']); $i++) {
                            $address = array(
                                'type'            => $request['type'][$i],
                                'city_id'         => $request['city_id'][$i],
                                'district_id'     => $request['district_id'][$i],
                                'street'          => $request['street'][$i],
                                'building_name'   => $request['building_name'][$i],
                                'floor'           => $request['floor'][$i],
                                'unit_number'     => $request['unit-number'][$i],
                                'location'        => $request['location'][$i],
                                'no_of_occupants' => $request['occupants'][$i],
                            );
                            if (array_key_exists($i, $request['address-id'])) {
                                $this->addressRepo->update($request['address-id'][$i], $address);
                            } else {
                                $address['user_id'] = $user_id;
                                $this->addressRepo->create($address);
                            }
                        }
                        DB::commit();
                        return true;
                    }

                } else {
                    if (sizeof($difference) > 0) {
                        foreach ($difference as $key => $diff) {
                            $this->addressRepo->destroy($diff);
                        }
                    }
                    DB::commit();
                    return true;
                }
            } else {
                DB::rollBack();
                return false;
            }
        } else {
            DB::rollBack();
            return false;
        }
    }

    /**
     * $param $id
     */

    public function delete(int $id)
    {
        $organization = $this->organizationRepo->findById($id);
        foreach ($organization->users as $user) {
            foreach ($user->addresses as $address) {
                $this->addressRepo->destroy($address->id);
            }

            $this->userService->destroy($user->id);
        }
        return $this->destroy($id);
    }

}
