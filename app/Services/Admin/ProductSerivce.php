<?php


namespace App\Services\Admin;


use App\Repositories\Admin\ProductRepo;
use App\Services\Admin\BaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductSerivce extends BaseService
{

    public function __construct()
    {
        $this->getRepo(ProductRepo::class);
    }


    /**
     * @param array $data
     * @return bool
     */
    public function create(array $data)
    {
        $input['avatar'] = time() . '.' . $data['avatar']->getClientOriginalExtension();
        $productData = array(
            'category_id' => $data['product_category'],
            'name' => $data['name'],
            'price' => $data['price'],
            'description' => $data['description'],
            'avatar' => $input['avatar'],
            'status' => $data['product_status'],
        );

        $product = parent::create($productData);

        if ($product) {
            // Storing image
            $data['avatar']->move(public_path('storage/images/products'), $input['avatar']);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param array $data
     * @param  int $id
     * @return bool
     */
    public function update(int $id, array $data)
    {
        $old_image = $this->findById($id)->avatar;
        $input['avatar'] = $old_image;
        if (array_key_exists('avatar', $data)) {
            $input['avatar'] = time() . '.' . $data['avatar']->getClientOriginalExtension();
        }
        $productData = array(
            'category_id' => $data['product_category'],
            'name' => $data['name'],
            'price' => $data['price'],
            'description' => $data['description'],
            'avatar' => $input['avatar'],
            'status' => $data['product_status'],
        );

        $product = parent::update($id, $productData);

        if ($product) {
            if (array_key_exists('avatar', $data)) {
                $data['avatar']->move(public_path('storage/images/products'), $input['avatar']);

                $image_path = public_path('storage/images/products/') . $old_image;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * $param $id
     */

    public function destroy(int $id)
    {

        $image = $this->findById($id)->avatar ;
        $product =  parent::destroy($id);

        if($product){
            $image_path = public_path('storage/images/products/').$image;
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
          return true ;
        }
        else{
          return false;
        }
    }

}
