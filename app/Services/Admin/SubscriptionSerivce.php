<?php


namespace App\Services\Admin;


use App\Repositories\Admin\SubscriptionRepo;
use App\Services\Admin\BaseService;
use App\Services\ICategoryType;
use App\Services\ISubscriptionType;
use App\Services\ITrips;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Services\StripeService;

class SubscriptionSerivce extends BaseService
{

    private $subscriptionRepo;
    private  $stripeService;

    public function __construct()
    {
        $this->subscriptionRepo = $this->getRepo(SubscriptionRepo::class);
        $this->stripeService = new StripeService();
    }

    /**
     * @param array $data
     * @return bool
     */

    public function insert($request)
    {
        $data = $request->except('_token');
        if(!$request->has('request_allowed')){
            $data["request_allowed"] = ITrips::ONE_TRIP;
        }

        //check that avatar exists or not
        if(array_key_exists('avatar', $data) && $data['avatar'] != null){
            $data = $this->uploadFile($data, $request);
        }
        $subscription = parent::create($data);

        if($subscription) {

            if ($data['category_id'] == ISubscriptionType::MONTHLY) {
                //add subscription to stripe
                $stripeData = [
                    'name' => $request['name'],
                    'price' => $request['price']
                ];

                $stripeProduct = $this->stripeService->addProduct($stripeData);

                //store stripe product id to product table
                $stripe['stripe_product_id'] = $stripeProduct['id'];

                return parent::update($subscription->id, $stripe);
            }

            return true;
        }

        else {
            return false ;
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
        if($request->has('request_allowed')){
            $data["category_type"] = null;
        }
        else{
            $data["request_allowed"] = ITrips::ONE_TRIP;
        }

        //check that avatar exists or not
        if(array_key_exists('avatar', $data) && $data['avatar'] != null){
            $data = $this->uploadFile($data, $request);
        }
        return parent::update($id, $data);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id)
    {
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
            $getOldData = $this->subscriptionRepo->findById($id);
            if($getOldData->avatar != null){
                Storage::disk()->delete(config('filesystems.subscription_avatar_upload_path').$getOldData->avatar);
            }
        }
        //upload new image
        $fileName = 'image-'.time().'-'.$request->file('avatar')->getClientOriginalName();
        $filePath = config('filesystems.subscription_avatar_upload_path').$fileName;
        Storage::disk()->put($filePath, file_get_contents($request->file('avatar')),'public');
        $data['avatar'] = $fileName;

        return $data;

    }

}
