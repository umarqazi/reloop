<?php


namespace App\Services\Admin;


use App\Repositories\Admin\SubscriptionRepo;
use App\Services\Admin\BaseService;
use App\Services\ICategoryType;
use App\Services\ISubscriptionType;
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

}
