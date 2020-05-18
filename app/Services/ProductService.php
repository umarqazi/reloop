<?php


namespace App\Services;


use App\Category;
use App\Forms\IForm;
use App\Forms\Product\CategoryProductsForm;
use App\Helpers\IResponseHelperInterface;
use App\Helpers\ResponseHelper;
use App\Product;
use App\Subscription;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\ValidationException;

/**
 * Class ProductService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Feb 27, 2020
 * @project   reloop
 */
class ProductService extends BaseService
{

    private $category;
    private $subscription;
    private $product;

    /**
     * ProductService constructor.
     * @param Category $category
     * @param Product $product
     * @param Subscription $subscription
     */
    public function __construct(Category $category, Product $product, Subscription $subscription)
    {
        parent::__construct();
        $this->category = $category;
        $this->product = $product;
        $this->subscription = $subscription;
    }

    /**
     * @inheritDoc
     */
    public function store(IForm $form)
    {
        // TODO: Implement store() method.
    }

    /**
     * @inheritDoc
     */
    public function findById($id)
    {
        // TODO: Implement findById() method.
    }

    /**
     * @inheritDoc
     */
    public function remove($id)
    {
        // TODO: Implement remove() method.
    }

    /**
     * Method: categoriesList
     *
     * @return Category[]|\Illuminate\Database\Eloquent\Collection
     */
    public function categoriesList()
    {
        $category = $this->category->all();
        return $category;
    }

    /**
     * Method: categoryProducts
     *
     * @param IForm $category
     *
     * @return mixed
     */
    public function categoryProducts(IForm $category)
    {
        if ($category->fails())
        {
            return ResponseHelper::responseData(
                Config::get('constants.RECORD_NOT_FOUND'),
                IResponseHelperInterface::FAIL_RESPONSE,
                false,
                $category->errors()
            );
        }

        $cat = $this->category->where('id', $category->category_id)->first();
        if($cat){

            if($cat->type == ICategoryType::SUBSCRIPTION){

                $categoryProducts = $this->subscription->where(['category_id' => $category->category_id, 'status' => true])->get();
            } else {

                $authUser = App::make(UserService::class)->findById(auth()->id());
                $categoryProducts = $this->product->where([
                    'category_id' => $category->category_id,
                    'status' => true,
                    'product_for' => $authUser->user_type
                ])->orWhere(function($query) use ($category) {
                    $query->where('category_id', $category->category_id)
                        ->where('product_for', IProductFor::BOTH);
                })->get();
            }
        }

        return ResponseHelper::responseData(
            Config::get('constants.PRODUCTS_SUCCESS'),
            IResponseHelperInterface::SUCCESS_RESPONSE,
            true,
            $categoryProducts
        );
    }

    /**
     * Method: findSubscriptionById
     *
     * @param $id
     *
     * @return mixed
     */
    public function findSubscriptionById($id)
    {
        return $this->subscription->where(['id' => $id, 'status' => true])->first();
    }

    /**
     * Method: findProductById
     *
     * @param $data
     *
     * @return mixed
     */
    public function findProductById($data)
    {
        return $this->product->find(array_column($data, 'id'));
    }

    /**
     * Method: getProductsByCategoryId
     *
     * @param $categoryId
     *
     * @return mixed
     */
    public function getProductsByCategoryId($categoryId)
    {
        $cat = $this->category->where('id', $categoryId)->first();
        if($cat){

            if($cat->type == ICategoryType::SUBSCRIPTION){

                $categoryProducts = $this->subscription->where(['category_id' => $categoryId, 'status' => true])->get();
            } else {

                $categoryProducts = $this->product->where(['category_id' => $categoryId, 'status' => true])->get();
            }
            return $categoryProducts;
        }
    }
}
