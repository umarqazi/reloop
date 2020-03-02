<?php


namespace App\Services\Admin;


use App\Repositories\Admin\SubscriptionRepo;
use App\Services\Admin\BaseService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SubscriptionSerivce extends BaseService
{

    private $subscriptionRepo;

    public function __construct()
    {
        $this->subscriptionRepo = $this->getRepo(SubscriptionRepo::class);
    }

    /**
     * @param array $data
     * @return bool
     */

    public function insert($request)
    {
        //check that avatar exists or not
        $data = $request->except('_token');
        if(array_key_exists('avatar', $data) && $data['avatar'] != null){
            $data = $this->uploadFile($data, $request);
        }
        return parent::create($data);

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
            Storage::disk()->delete(config('filesystems.subscription_avatar_upload_path').$image);
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
            //Deleting the existing image of respective subscription if exists.
            $getOldData = $this->subscriptionRepo->findById($id);
            if($getOldData->avatar != null){
                Storage::disk()->delete(config('filesystems.subscription_avatar_upload_path').$getOldData->avatar);
            }
        }
        //upload new subscription
        $fileName = 'image-'.time().'-'.$request->file('avatar')->getClientOriginalName();
        $filePath = config('filesystems.subscription_avatar_upload_path').$fileName;
        Storage::disk()->put($filePath, file_get_contents($request->file('avatar')),'public');
        $data['avatar'] = $fileName;

        return $data;

    }
}
