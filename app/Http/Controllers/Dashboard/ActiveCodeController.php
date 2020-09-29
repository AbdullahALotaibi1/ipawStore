<?php

namespace App\Http\Controllers\Dashboard;

use App\ActiveCode;
use App\ConstantsHelper;
use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActiveCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activeCodes = ActiveCode::orderBy('id', 'DESC')->paginate(50);

        return view('dashboard.activeCode.index', compact('activeCodes'));
    }

    public function create(Request $request)
    {
        $numActiveCode = $request->num_active_code;
        if($numActiveCode >= 1 && $numActiveCode <= 100)
        {
            for($x = 1; $x <= $numActiveCode; $x++){
                $randActiveCode = $this->generateActiveCode();
                $checkCode = ActiveCode::where('code', '=', $randActiveCode)->count();
                if($checkCode == 0){
                    $create = ActiveCode::create([
                        'code' => $randActiveCode
                    ]);
                }else{
                    $randActiveCode = $this->generateActiveCode(10);
                    $create = ActiveCode::create([
                        'code' => $randActiveCode
                    ]);
                }

            }
            return response()->json([
                'success' => true,
                'message' => 'تم انشاء '.$numActiveCode.' كود جديد',
            ]);
        }else{
            return response()->json([
                'success' => true,
                'message' => 'قيمة عدد الكواد غير صحيحة',
            ]);
        }
    }


    public function deleteAjax(Request $request)
    {
        $activeCode = ActiveCode::where('id', '=', $request->active_id)->where('customer_id', '=', null);
        if($activeCode->count() != 0){
            $activeCode->delete();
            return Response()->json([
                'success' => true,
                'message' => 'تم حذف كود التفعيل بنجاح'
            ]);
        }

        return Response()->json([
            'success' => false,
            'message' => 'الكود مستخدم لايمكن حذفة'
        ]);
    }


    private function generateActiveCode($length = 9) {
        $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $ret = '';
        for($i = 0; $i < $length; ++$i) {
            $random = str_shuffle($chars);
            $ret .= $random[0];
        }
        return $ret;
    }

}
