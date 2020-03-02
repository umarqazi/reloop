<?php


namespace App\Services;


use App\Category;
use App\Forms\IForm;
use App\Forms\Product\CategoryProductsForm;
use App\Product;
use App\Subscription;
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
            return $category->errors();
        }
        if($category->category_type == ICategoryType::SUBSCRIPTION){

            $categoryProducts = $this->category->where([
                'id' => $category->category_id,
                'type' => $category->category_type
            ])->with('subscriptions')->get();
        } else {

            $categoryProducts = $this->category->where([
                'id' => $category->category_id,
                'type' => $category->category_type
            ])->with('products')->get();
        }
        return $categoryProducts;
    }
}
