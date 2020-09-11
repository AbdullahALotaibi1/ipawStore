<?php

namespace App\Http\Controllers\Dashboard;

use App\BankAccounts;
use App\ConstantsHelper;
use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class BankAccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banks = BankAccounts::all();
        return view('dashboard.bankAccounts.index', compact('banks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.bankAccounts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // MARK: - Validation request data
        $validationData = Validator::make($request->all(), [
            'bank_name' => 'required|min:3',
            'owner_name' => 'required|min:3',
            'account_number' => 'required|min:5',
            'iban' => 'required|min:5',
            'bank_image' => 'required|max:2048|image|mimes:jpeg,png,jpg',
        ]);

        // MARK: - validator fails
        if($validationData->fails())
        {
            return redirect()->back()->withErrors($validationData->errors())->withInput();
        }

        // MARK: - images
        if($request->hasFile('bank_image')){
            $imagePath = storage_path('app/public/images/banks');
            $file = $request->file('bank_image');
            $fileName = sha1(date('YmdHis') . uniqid());
            $saveFullName = $fileName . '.' . $file->getClientOriginalExtension();
            $upload = $file->move($imagePath, $saveFullName);
        }

        if(isset($upload)){
            $create = BankAccounts::create([
                'bank_name' => $request->bank_name,
                'owner_name' => $request->owner_name,
                'account_number' => $request->account_number,
                'iban' => $request->iban,
                'bank_image' => $saveFullName,
            ]);
        }else{
            return Redirect::route('dashboard.accounts.index');
        }

        if(isset($create))
        {
            Session::flash('message', 'تم اضافة الحساب بنجاح');
            return Redirect::route('dashboard.accounts.index');
        }else{
            return Redirect::route('dashboard.accounts.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BankAccounts  $bankAccounts
     * @return \Illuminate\Http\Response
     */
    public function edit($account)
    {
        $bankAccounts = BankAccounts::find($account);
        if($bankAccounts->count() != 0){
            return view('dashboard.bankAccounts.edit', compact('bankAccounts'));
        }else{
            return Redirect::route('dashboard.accounts.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BankAccounts  $bankAccounts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $account)
    {
        $bankAccounts = BankAccounts::find($account);
        if($bankAccounts->count() != 0){
        // MARK: - Validation request data
        $validationData = Validator::make($request->all(), [
            'bank_name' => 'required|min:3',
            'owner_name' => 'required|min:3',
            'account_number' => 'required|min:5',
            'iban' => 'required|min:5',
            'bank_image' => 'nullable|max:2048|image|mimes:jpeg,png,jpg',
        ]);

        // MARK: - validator fails
        if($validationData->fails())
        {
            return redirect()->back()->withErrors($validationData->errors())->withInput();
        }

        // MARK: - image
        if($request->hasFile('bank_image')){
            $imagePath = storage_path('app/public/images/banks');
            // MARK:- Delete Image
            $fullPath = $imagePath.'/'.$bankAccounts->bank_image;
            $deleteFile = File::delete($fullPath);

            // MARK:- Upload New Image
            if(isset($deleteFile))
            {
                $file = $request->file('bank_image');
                $fileName = sha1(date('YmdHis') . uniqid());
                $saveFullName = $fileName . '.' . $file->getClientOriginalExtension();
                $upload = $file->move($imagePath, $saveFullName);
            }
        }else{
            $saveFullName = $bankAccounts->bank_image;
        }

        $update = $bankAccounts->update([
            'bank_name' => $request->bank_name,
            'owner_name' => $request->owner_name,
            'account_number' => $request->account_number,
            'iban' => $request->iban,
            'bank_image' => $saveFullName,
        ]);

        if(isset($update))
        {
            Session::flash('message', 'تم تعديل ('.$request->bank_name.') بنجاح');
            return Redirect::route('dashboard.accounts.index');
        }else{
            return Redirect::route('dashboard.accounts.index');
        }

        }else{
            return Redirect::route('dashboard.accounts.index');
        }

    }

    public function deleteAjax(Request $request)
    {
        $bankAccount = BankAccounts::find($request->bank_id);;

        if($bankAccount->count() != 0){
            $imagePath = storage_path('app/public/images/banks');
            // MARK:- Delete Image
            $fullPath = $imagePath.'/'.$bankAccount->bank_image;
            $deleteFile = File::delete($fullPath);

            if(isset($deleteFile)){
                $bankAccount->delete();
                return Response()->json([
                    'success' => true,
                    'message' => 'تم حذف الحساب بنجاح'
                ]);
            }else{
                return Response()->json([
                    'success' => false,
                    'message' => 'حدث خطاء غير متوقع'
                ]);
            }

        }

        return Response()->json([
            'success' => false,
            'message' => 'حدث خطاء غير متوقع'
        ]);
    }
}
