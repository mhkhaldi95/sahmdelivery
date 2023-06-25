<?php

namespace App\Http\Controllers;

use App\Constants\Enum;
use App\Constants\StatusCodes;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function invalidIntParameter()
    {
        return back()->with([
            'message' => __('lang.something went error'),
            'alert-type' => 'error'
        ]);
    }
    public function invalidIntParameterJson(): JsonResponse
    {
        return response()->json([
            'status' => false,
            'code' => StatusCodes::INTERNAL_ERROR,
            'message' => 'خطا عام',
            'data' => [],
        ],StatusCodes::INTERNAL_ERROR);
    }
    public function response_json($status, $code, $message, $data = [], $extra_data = [])
    {
        $response = array_merge([
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ], $extra_data);
        return response()->json($response, $code);
    }
    public function returnBackWithSaveDone(){
        return back()->with([
            'message' => __('lang.save_done'),
            'alert-type' => 'success'
        ]);
    }
    public function returnBackWithPaymentDone(){
        return redirect()->route('break.index')->with([
            'message' => __('lang.payment_done'),
            'alert-type' => 'success'
        ]);
    }
    public function returnBackWithPaymentFailed(){
        return redirect()->route('break.index')->with([
            'message' => __('lang.payment_failed'),
            'alert-type' => 'error'
        ]);
    }
    public function returnBackWithSaveDoneFailed(){
        return back()->with([
            'message' => __('lang.save_failed'),
            'alert-type' => 'error'
        ]);
    }
}
