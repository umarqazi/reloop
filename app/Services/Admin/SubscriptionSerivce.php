<?php


namespace App\Services\Admin;


use App\Repositories\Admin\SubscriptionRepo;
use App\Services\Admin\BaseService;
use Illuminate\Support\Facades\File;

class SubscriptionSerivce extends BaseService
{

    public function __construct()
    {
        $this->getRepo(SubscriptionRepo::class);
    }

    /**
     * @param array $data
     * @return bool
     */

    public function create(array $data)
    {
        $input['avatar'] = time().'.'.$data['avatar']->getClientOriginalExtension();

        $subscriptionData = array(
            'category_id'     => $data['subscription_category'],
            'name'            => $data{'name'} ,
            'price'           => $data['price'] ,
            'description'     => $data['description'] ,
            'request_allowed' => $data['request_allowed'] ,
            'avatar'          => $input['avatar'] ,
            'status'          => $data['subscription_status'] ,
        );

        $subscription =  parent::create($subscriptionData);

        if($subscription){
            // Storing image
            $data['avatar']->move(public_path('storage/images/subscriptions'), $input['avatar']);
            return true ;
        }
        else{
            return false;
        }
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data)
    {
        $old_image = $this->findById($id)->avatar ;
        $input['avatar']  = $old_image ;

        if (array_key_exists('avatar', $data)) {
            $input['avatar'] = time().'.'.$data['avatar']->getClientOriginalExtension();
        }
        $subscriptionData = array(
            'category_id'     => $data['subscription_category'],
            'name'            => $data{'name'} ,
            'price'           => $data['price'] ,
            'description'     => $data['description'] ,
            'request_allowed' => $data['request_allowed'] ,
            'avatar'          => $input['avatar'] ,
            'status'          => $data['subscription_status'] ,
        );

        $subscription =  parent::update($id, $subscriptionData);

        if($subscription){
            if (array_key_exists('avatar', $data)) {
                $input['avatar'] = time().'.'.$data['avatar']->getClientOriginalExtension();
                $data['avatar']->move(public_path('storage/images/subscriptions'), $input['avatar']);

                $image_path = public_path('storage/images/subscriptions/').$old_image;
                if(File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            return true ;
        }
        else{
            return false;
        }
    }

    /**
     * @param int $id
     * @return bool
     */
    public function destroy(int $id)
    {
        $image = $this->findById($id)->avatar ;
        $product = parent::destroy($id);
        if($product) {
            $image_path = public_path('storage/images/subscriptions/') . $image;
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            return true ;
        }
        else{
            return false;
        }
    }
}
