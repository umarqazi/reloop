<?php


namespace App\Services\Admin;


use App\Repositories\Admin\AddressRepo;
use App\Repositories\Admin\UserRepo;
use App\Services\EmailNotificationService;
use App\Services\IUserStatus;
use App\Services\IUserType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UserService extends BaseService
{
    private $userRepo;
    private $addressRepo;
    /**
     * Property: emailNotificationService
     *
     * @var EmailNotificationService
     */
    private $emailNotificationService;


    public function __construct(EmailNotificationService $emailNotificationService,AddressRepo $addressRepo)
    {
        $userRepo = $this->getRepo(UserRepo::class);
        $this->userRepo = new $userRepo;
        $this->addressRepo  = $addressRepo;
        $this->emailNotificationService = $emailNotificationService;
    }

    /**
     * @param $type
     * @param $role
     * @return mixed
     */
    public function getSelected($type)
    {
        return $this->userRepo->getSelected($type);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function insert($request)
    {
        //check that avatar exists or not
        $data = $request->except('_token');
        if(array_key_exists('avatar', $data) && $data['avatar'] != null){
            $data = $this->uploadFile($data, $request);
        }
        $userData = array(

            'first_name'      => $data['first_name'],
            'last_name'       => $data['last_name'],
            'email'           => $data['email'],
            'birth_date'      => $data['birth_date'],
            'avatar'          => $data['avatar'],
            'phone_number'    => $data['phone_number'],
            'password'        => $data['password'],
            'status'          => $data['status'],
            'user_type'       => $data['user_type'],
        );

        DB::beginTransaction();

        $user =  parent::create($userData);

        if($user){
                $address = array(
                    'user_id'         => $user->id,
                    'location'        => $data['location'],
                );

                $this->addressRepo->create($address);

        if($data['user_type'] == IUserType::HOUSE_HOLD){
            $this->emailNotificationService->adminUserCreateEmail($data);
        }

        elseif($data['user_type'] == IUserType::SUPERVISOR){
            $this->emailNotificationService->adminSupervisorCreateEmail($data);
        }

        elseif($data['user_type'] == IUserType::DRIVER){
            $this->emailNotificationService->adminDriverCreateEmail($data);
        }
            DB::commit();
            return $user;
        }
        else{
            DB::rollBack();
            return  false;
        }
    }

    /**
     * @param int $id
     * @param array $request
     * @return mixed
     */
    public function upgrade($id, $request)
    {
        $data = $request->except('_token', '_method', 'email');

        $userData = array(
            'first_name'      => $data['first_name'],
            'last_name'       => $data['last_name'],
            'birth_date'      => $data['birth_date'],
            'phone_number'    => $data['phone_number'],
            'status'          => $data['status'],
            'user_type'       => $data['user_type'],
        );
        if(array_key_exists('avatar', $data) && $data['avatar'] != null){
            $data = $this->uploadFile($data, $request, $id);
            $userData['avatar']  = $data['avatar'];
        }

        DB::beginTransaction();

        $user =  parent::update($id, $userData);

        if($user){

            if($data['user_type'] == IUserType::HOUSE_HOLD){
                $update_address = array(
                    'city_id'         => $request['city_id'],
                    'location'        => $request['location'],
                    'type'            => $request['type'],
                    'no_of_bedrooms'  => $request['bedrooms'],
                    'no_of_occupants' => $request['occupants'],
                    'district_id'     => $request['district_id'],
                    'street'          => $request['street'],
                    'floor'           => $request['floor'],
                    'unit_number'     => $request['unit-number'],
                );
            }
            else{
                $update_address = array(
                    'location'        => $request['location'],
                );
            }
            $user_addresses = $this->findById($id)->addresses;

            if(sizeof($user_addresses) > 0){
                $address_id  = $user_addresses[0]->id;
                $this->addressRepo->update($address_id,$update_address);
            }

            DB::commit();
            return true;
        }
        else{
            DB::rollBack();
            return false;
        }


    }

    /**
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id)
    {
        $image = $this->findById($id)->avatar ;
        if($image != null) {
            Storage::disk()->delete(config('filesystems.user_avatar_upload_path').$image);
        }

        $user = $this->findById($id);

        foreach ($user->addresses as $address){
            $this->addressRepo->destroy($address->id);
        }

        return parent::destroy($id);
    }

    /**
     * @param $data
     * @param $request
     * @param null $id
     * @return mixed
     */
    public function uploadFile($data, $request, $id = null)
    {
        if($id != null){
            //Deleting the existing image of respective user.
            $getOldData = $this->userRepo->findById($id);
            if($getOldData->avatar != null){
                Storage::disk()->delete(config('filesystems.user_avatar_upload_path').$getOldData->avatar);
            }
        }
        //upload new image
        $fileName = 'image-'.time().'-'.$request->file('avatar')->getClientOriginalName();
        $filePath = config('filesystems.user_avatar_upload_path').$fileName;
        Storage::disk()->put($filePath, file_get_contents($request->file('avatar')),'public');
        $data['avatar'] = $fileName;

        return $data;

    }

    public function update(int $id, array $data)
    {
        $user = $this->userRepo->findById($id);
        $rewardPoints = $user->reward_points - $data['redeem_points'];
        $data = array(
            'reward_points' => $rewardPoints
        );
        return parent::update($id, $data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function userUpdate(int $id, array $data)
    {
        return parent::update($id, $data);
    }
}
