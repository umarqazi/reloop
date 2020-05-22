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
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Services\EmailNotificationService;

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
