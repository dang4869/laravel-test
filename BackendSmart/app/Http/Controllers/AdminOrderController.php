<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    //
    function show()
    {
        $orders = Order::orderby('id', 'DESC')->paginate(10);
        $order_success = Order::where('order_status', 2)->count();
        $order_loading = Order::where('order_status', 0)->count();
        $order_cancel = Order::where('order_status', 3)->count();
        $total = Order::where('order_status', 2)->sum('price_total');

        return response()->json([
            'data' => $orders,
            'order_success' => $order_success,
            'order_loading' => $order_loading,
            'order_cancel' => $order_cancel,
            'total' => $total
        ]);
    }
    function detailOrder($id){
        $order = Order::find($id);
        $orderDetail = OrderDetail::with('product')->where('order_id',$order->id)->get();
        return response()->json([
            'sucess' => true,
            'message'=> 'Chi tiết sản phẩm',
            'data' => $orderDetail,
            'order'=>$order
        ]);
    }
    function updateStatus(Request $request, $id){
        Order::where('id',$id)->update([
            'order_status'=>$request->status
          ]);
         return response()->json([
            'status' => true,
            'message'=> 'Cập nhật trạng thái đơn hàng thành công'
         ]);
    }
    function delete($id){
        Order::where('id',$id)->delete();
        return response()->json([
            'status' => true,
            'message'=> 'Xóa đơn hàng thành công'
         ]);
    }
}
