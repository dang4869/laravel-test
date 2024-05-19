<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //
    function addOrder(Request $request)
    {
        $input = $request->all();
        $rules = [
            'order_name' => 'required',
            'address' => 'required',
            'phone' => 'required',
        ];
        $message = [
            'required' => ':attribute không được để trống',
            'min' => ':attribute có độ dài ít nhất :min ký tự',
            'max' => ':attribute có độ dài tối đa :max ký tự',
        ];
        $validator = Validator::make(
            $input,
            $rules,
            $message
        );
        if ($validator->fails()) {
            $arr = [
                'success' => false,
                'message' => 'Thêm mới đơn hàng không thành công',
                'error' => $validator->errors()
            ];
            return response()->json($arr, 500);
        }
        $data = array();
        $data['order_code'] = 'UNIMART-' . rand(0, 9999);
        $data['order_name'] = $request->input('order_name');
        $data['email'] = $request->input('email');
        $data['address'] = $request->input('address');
        $data['phone'] = $request->input('phone');
        $data['notes'] = $request->input('notes');
        $data['order_status'] = 0;
        $data['payment'] = $request->input('payment');
        $data['created_at'] = Carbon::now();
        $data['price_total'] = $request->input('price_total');
        $order_id = DB::table('orders')->insertGetId($data);
        $arr = [
            'status' => true,
            'data' => $order_id
        ];
        return response()->json($arr, 200);
    }
    function addDetailOrder(Request $request)
    {
        $input = $request->all();
        $rules = [
            'order_id' => 'required',
            'product_id' => 'required',
        ];
        $message = [
            'required' => ':attribute không được để trống',
            'min' => ':attribute có độ dài ít nhất :min ký tự',
            'max' => ':attribute có độ dài tối đa :max ký tự',
        ];
        $validator = Validator::make(
            $input,
            $rules,
            $message
        );
        if ($validator->fails()) {
            $arr = [
                'success' => false,
                'message' => 'Thêm mới đơn hàng không thành công',
                'error' => $validator->errors()
            ];
            return response()->json($arr, 500);
        }
        OrderDetail::create([
            'order_id' => $request->input('order_id'),
            'product_id' => $request->input('product_id'),
            'product_qty' => $request->input('product_qty'),
            'total' => $request->input('total')
        ]);
        $arr = [
            'status' => true,
            'message' => 'Thêm mới đơn hàng thành công'
        ];
        return response()->json($arr, 200);
    }
}
