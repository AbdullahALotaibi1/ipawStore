<?php

namespace App\Http\Controllers\Dashboard;

use App\ApplicationsInfo;
use App\ConstantsHelper;
use App\Customer;
use App\Group;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //

    public function index()
    {
        $countGroups = Group::all()->count();
        $countCustomers = Customer::where('status', '!=', ConstantsHelper::NEW_ORDERS_CUSTOMER)->count();
        $lastOrders = Customer::where('status', '=', ConstantsHelper::NEW_ORDERS_CUSTOMER)->take(10)->get();
        $countOrders = Customer::where('status', '=', ConstantsHelper::NEW_ORDERS_CUSTOMER)->count();
        $countApplications = ApplicationsInfo::all()->count();
        return view('dashboard.home.index', compact('countGroups', 'countCustomers', 'countOrders', 'countApplications', 'lastOrders'));
    }
}
