<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Subscription\CreateRequest;
use App\Http\Requests\Subscription\UpdateRequest;
use App\Services\Admin\SubscriptionSerivce;
use Illuminate\Support\Facades\File;

class SubscriptionController extends Controller
{

    /**
     * ProductController constructor.
     */
    public function __construct() {
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
        return view('subscriptions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {

        // Storing image
        $input['avatar'] = time().'.'.$request->avatar->getClientOriginalExtension();
        $request->avatar->move(public_path('storage/images/subscriptions'), $input['avatar']);

        $productData = array(
            'category_id'     => $request->subscription_category,
            'name'            => $request->name ,
            'price'           => $request->price ,
            'description'     => $request->description ,
            'request_allowed' => $request->request_allowed ,
            'avatar'          => $input['avatar'] ,
            'status'          => $request->subscription_status ,
        );

        $this->subscriptionService->create($productData);
        return redirect()->route('subscription.index');
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
        $old_image = $this->subscriptionService->findById($id)->avatar ;
        $input['avatar']  = $old_image ;

        if ($request->hasFile('avatar')) {
            $input['avatar'] = time().'.'.$request->avatar->getClientOriginalExtension();
            $request->avatar->move(public_path('storage/images/subscriptions'), $input['avatar']);

            $image_path = public_path('storage/images/subscriptions/').$old_image;
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
        }
        $productData = array(
            'category_id'     => $request->subscription_category,
            'name'            => $request->name ,
            'price'           => $request->price ,
            'description'     => $request->description ,
            'avatar'          => $input['avatar'] ,
            'request_allowed' => $request->request_allowed ,
            'status'          => $request->subscription_status ,);
        $this->subscriptionService->update($id,$productData);
        return redirect()->route('subscription.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = $this->subscriptionService->findById($id)->avatar ;
        //Delete Image
        $image_path = public_path('storage/images/subscriptions/').$image;
        if(File::exists($image_path)) {
            File::delete($image_path);
        }
        $this->subscriptionService->destroy($id);
        return redirect()->route('subscription.index');
    }
}
