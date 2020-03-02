<?php


namespace App\Services\Admin;


use App\Repositories\Admin\ProductRepo;
use App\Services\Admin\BaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductService extends BaseService
{

    private $productRepo;

    /**
     * ProductService constructor.
     */

    public function __construct()
    {
        $productRepo =  $this->getRepo(ProductRepo::class);
        $this->productRepo = new $productRepo;
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
     * @param array $data
     * @param  int $id
     * @return bool
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
            Storage::disk()->delete(config('filesystems.product_avatar_upload_path').$image);
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
            //Deleting the existing image of respective product if exists.
            $getOldData = $this->productRepo->findById($id);
            if($getOldData->avatar != null){
                Storage::disk()->delete(config('filesystems.product_avatar_upload_path').$getOldData->avatar);
            }
        }
        //upload new image
        $fileName = 'image-'.time().'-'.$request->file('avatar')->getClientOriginalName();
        $filePath = config('filesystems.product_avatar_upload_path').$fileName;
        Storage::disk()->put($filePath, file_get_contents($request->file('avatar')),'public');
        $data['avatar'] = $fileName;

        return $data;

    }

}
