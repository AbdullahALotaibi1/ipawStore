<?php

namespace App\Http\Controllers\Dashboard;

use App\ConstantsHelper;
use App\Customer;
use App\Group;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::where('status', '!=', ConstantsHelper::NEW_ORDERS_CUSTOMER)->paginate(30);
        return view('dashboard.customers.index', compact('customers'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('dashboard.customers.edit', compact('customer'));
    }

    public function show(Customer $customer)
    {
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
        // MARK: - Validation request data
        $validationData = Validator::make($request->all(), [
            'full_name' => 'required',
            'phone_number' => 'required|integer',
            'status' => 'required',
        ]);

        // MARK: - validator fails
        if($validationData->fails())
        {
            return redirect()->back()->withErrors($validationData->errors())->withInput();
        }

        if($customer->status == ConstantsHelper::NEED_UPDATE_PROFILE_CUSTOMER){
            $request->status = 1;
        }

        // MARK:- Update Customer
        $update = $customer->update([
            'full_name' => $request->full_name,
            'phone_number' => $request->phone_number,
            'status' => $request->status,
        ],[
            'phone_number.integer' => 'الرجاء ادخال رقم الجوال بطريقة 966555555555'
        ]);

        return Redirect::route('dashboard.customers.index');
    }

    public function deleteAjax(Request $request)
    {
        $customer = Customer::where('id', '=', $request->customer_id)->where('status', '!=', ConstantsHelper::NEW_ORDERS_CUSTOMER);
        if($customer->count() != 0){
            $customer->delete();
            return Response()->json([
                'success' => true,
                'message' => 'تم حذف المشترك بنجاح'
            ]);
        }

        return Response()->json([
            'success' => false,
            'message' => 'حدث خطاء غير متوقع'
        ]);
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

