<?php

namespace App\Http\Controllers\Dashboard;

use App\Customer;
use App\Group;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }


    public function compensationOfSpecificCustomers(Request $request)
    {
        $groupData = Group::find($request->group_id);

        foreach ($groupData->customers()->get() as $customer)
        {
            if($customer->getStatusCompensation()['status_id'] == 1){
                $checkUdid = Customer::where('udid', '=', $customer->udid)->where('group_id', '=', $request->new_group_id);
                if($checkUdid->count() == 0){
                    $updateCustomer = Customer::where('udid', '=', $customer->udid)->where('group_id', '=', $request->group_id)->update([
                        'group_id' => $request->new_group_id
                    ]);
                }
            }
        }

        return "success";
    }

    public function compensationOfAllCustomers(Request $request)
    {
        $groupData = Group::find($request->group_id);

        foreach ($groupData->customers()->get() as $customer)
        {
            $checkUdid = Customer::where('udid', '=', $customer->udid)->where('group_id', '=', $request->new_group_id);
            if($checkUdid->count() == 0){
                $updateCustomer = Customer::where('udid', '=', $customer->udid)->where('group_id', '=', $request->group_id)->update([
                    'group_id' => $request->new_group_id
                ]);
            }
        }

        return "success";
    }

}

