<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Subscription\CreateRequest;
use App\Http\Requests\Subscription\UpdateRequest;
use App\Repositories\Admin\CategoryRepo;
use App\Services\Admin\SubscriptionSerivce;
use App\Services\ICategoryType;
use Illuminate\Support\Facades\File;

class SubscriptionController extends Controller
{

    private $categoryRepository ;
    /**
     * ProductController constructor.
     */
    public function __construct(CategoryRepo $categoryRepository) {
        $this->categoryRepository =  $categoryRepository;
        $this->subscriptionService = new SubscriptionSerivce();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscriptions = $this->subscriptionService->all() ?? null ;
        return view('subscriptions.index', compact('subscriptions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categoryRepository->getCategory(ICategoryType::SUBSCRIPTION)->pluck('name', 'id')->toArray();
        return view('subscriptions.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        if(!empty($request)){
            $subscription = $this->subscriptionService->insert($request);
            if($subscription){
                return redirect()->back()->with('success','Subscription Created Successfully');
            } else {
                return redirect()->back()->with('error','Error While Creating Subscription');
            }
        }else{
            return redirect()->back()->with('error','Error While Creating Subscription');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subscription = $this->subscriptionService->findById($id);
        $categories = $this->categoryRepository->getCategory(ICategoryType::SUBSCRIPTION)->pluck('name', 'id')->toArray();
        if($subscription){
            return view('subscriptions.edit', compact('subscription','categories'));
        }else{
            return view('subscriptions.edit')->with('error', 'No Information Founded !');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        if(!empty($request)){
            $subscription = $this->subscriptionService->upgrade($id, $request);
            if($subscription){
                return redirect()->back()->with('success','Subscription Update Successfully');
            } else {
                return redirect()->back()->with('error','Error While Updating Subscription');
            }
        }else{
            return redirect()->back()->with('error','Error While Updating Subscription');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = $this->subscriptionService->destroy($id);
        if($product){
            return redirect()->route('subscription.index')->with('success','Subscription Deleted Successfully');
        }
        else{
            return redirect()->route('subscription.index')->with('error','Something went wrong');
        }

    }
}
