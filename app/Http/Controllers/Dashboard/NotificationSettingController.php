<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\NotificationSetting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.notificationSetting.index');
    }

}
