<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Setting;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::all()->first();
        $user = User::all()->first();
        return view('dashboard.settings.index', compact('settings', 'user'));
    }


    public function update(Request $request)
    {
        // MARK: - Validation request data
        $validationData = Validator::make($request->all(), [
            'title' => 'required',
            'logo_store' => 'nullable|max:2048|image|mimes:jpeg,png,jpg',
            'app_bundle' => 'required',
            'description' => 'required',
            'keywords' => 'required',
            'conditions_order' => 'required',
            'status_store' => 'required',
            'status_orders' => 'required',
            'price_order' => 'required',
            'twitter_account' => 'required',
            'snapchat_account' => 'required',
            'telegram_account' => 'required',
            'whatsapp_account' => 'required',
            'email' => 'nullable|email',
        ]);

        // MARK: - Check if there error in request data
        if ($validationData->fails()){
            return redirect()->back()->withErrors($validationData->errors())->withInput();
        }

        $setting = Setting::all()->first();

        // MARK: - image
        if($request->hasFile('logo_store')){
            $imagePath = storage_path('app/public/images/logo');
            // MARK:- Delete Image
            $fullPath = $imagePath.'/'.$setting->logo_store;
            $deleteFile = File::delete($fullPath);

            // MARK:- Upload New Image
            $file = $request->file('logo_store');
            $fileName = sha1(date('YmdHis') . uniqid());
            $saveFullName = $fileName . '.' . $file->getClientOriginalExtension();
            $upload = $file->move($imagePath, $saveFullName);
        }else{
            $saveFullName = $setting->logo_store;
        }
        $de  = Setting::truncate();

        // Update
        $create = Setting::create([
            'title' => $request->title,
            'app_bundle' => $request->app_bundle,
            'logo_store' => $saveFullName,
            'description' => $request->description,
            'keywords' => $request->keywords,
            'conditions_order' => $request->conditions_order,
            'status_store' => $request->status_store,
            'price_order' => $request->price_order,
            'status_orders' => $request->status_orders,
            'twitter_account' => $request->twitter_account,
            'snapchat_account' => $request->snapchat_account,
            'telegram_account' => $request->telegram_account,
            'whatsapp_account' => $request->whatsapp_account,
        ]);

        if($request->email != null || $request->email != '') {
            $updateEmail = User::where('id', '=', 1)->update([
                'email' => $request->email,
            ]);
        }
        if($request->password != null || $request->password != '') {
            $updatePassword = User::where('id', '=', 1)->update([
                'password' => Hash::make($request->password),
            ]);
        }

        if(isset($create))
        {
            Session::flash('message', 'تم حفظ التعديلات بنجاح');
            return Redirect::route('dashboard.settings.index');
        }else{
            abort(404);
        }
    }
}
