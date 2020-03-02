<?php


namespace App\Services\Admin;


use App\Repositories\Admin\UserRepo;
use App\Services\EmailNotificationService;
use App\Services\IUserType;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UserService extends BaseService
{
    private $userRepo;
    /**
     * Property: emailNotificationService
     *
     * @var EmailNotificationService
     */
    private $emailNotificationService;


    public function __construct(EmailNotificationService $emailNotificationService)
    {
        $userRepo = $this->getRepo(UserRepo::class);
        $this->userRepo = new $userRepo;
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
        $user =  parent::create($data);

        if($user){

        if($data['user_type'] == IUserType::HOUSE_HOLD){
            $this->emailNotificationService->adminUserCreateEmail($data);
        }

        elseif($data['user_type'] == IUserType::SUPERVISOR){
            $this->emailNotificationService->adminSupervisorCreateEmail($data);
        }

        elseif($data['user_type'] == IUserType::DRIVER){
            $this->emailNotificationService->adminDriverCreateEmail($data);
        }
            return $user;
        }
        else{
            return  false;
        }
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function upgrade($id, $request)
    {
        $data = $request->except('_token', '_method', 'email');
        if(array_key_exists('avatar', $data) && $data['avatar'] != null){
            $data = $this->uploadFile($data, $request, $id);
        }
        return parent::update($id, $data);

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
}
