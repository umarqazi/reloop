<?php

namespace App\Services\Admin;

use App\Http\Requests\User\CreateRequest;
use App\Repositories\Admin\MaterialCategoryRepo;
use Illuminate\Support\Facades\Storage;

class MaterialCategoryService extends BaseService
{
    private $materialCategoyRepo;

    /**
     * MaterialCategoryService constructor.
     */
    public function __construct()
    {
        $materialCategory =  $this->getRepo(MaterialCategoryRepo::class);
        $this->materialCategoyRepo = new $materialCategory;
    }

    public function insert($request)
    {
        //check that avatar exists or not
        $data = $request->except('_token');
        if(array_key_exists('avatar', $data) && $data['avatar'] != null){
            $data = $this->uploadFile($data, $request);
        }
        return parent::create($data);
    }

    public function upgrade($id, $request)
    {
        $data = $request->except('_token', '_method', 'email');
        if(array_key_exists('avatar', $data) && $data['avatar'] != null){
            $data = $this->uploadFile($data, $request, $id);
        }
        return parent::update($id, $data);
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
            //Deleting the existing subtitles of respective video if exists.
            $getOldData = $this->materialCategoyRepo->findById($id);
            if($getOldData->avatar != null){
                Storage::disk()->delete(config('filesystems.material_category_avatar_upload_path').$getOldData->avatar);
            }
        }
        //upload new subtitle file
        $fileName = 'image-'.time().'-'.$request->file('avatar')->getClientOriginalName();
        $filePath = config('filesystems.material_category_avatar_upload_path').$fileName;
        Storage::disk()->put($filePath, file_get_contents($request->file('avatar')),'public');
        $data['avatar'] = $fileName;

        return $data;

    }
}
