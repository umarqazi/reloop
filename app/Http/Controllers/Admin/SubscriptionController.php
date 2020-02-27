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
        $subscriptions = $this->subscriptionService->all() ;
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
        $subscription = $this->subscriptionService->create($request->all());

        if($subscription){
            return redirect()->route('subscription.index')->with('success','Subscription Created Successfully');
        }

        else{
            return redirect()->route('subscription.index')->with('error','Something went wrong');
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
        return view('subscriptions.edit',compact('subscription'));
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
        $subscription = $this->subscriptionService->update($id,$request->all());

        if($subscription){

            return redirect()->route('subscription.edit',['id'=> $id])->with('success','Subscription Updated Successfully');
        }
        else{
            return redirect()->back()->with('error','Something went wrong');
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
