<?php

namespace App\Http\Controllers;

use App\Models\User;
use Elasticsearch\Endpoints\Sql\Query;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    function index(Request $request)
    {
        $keyword = "";
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
        }
        $users = User::where('name', 'LIKE', "%{$keyword}%")->orderBy('id', 'DESC')->paginate(10);
        $arr = [
            'status' => true,
            'message' => 'Danh sách người dùng',
            'count' => $users->count(),
            'data' => $users
        ];
        return response()->json($arr, 200);
    }
    function add(Request $request)
    {
        $input = $request->all();
        $rules = [
            'name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required'
        ];
        $message = [
            'required' => ' :attribute không được để trống',
            'min' => ' :attribute có độ dài ít nhất :min ký tự',
            'max' => ' :attribute có độ dài tối đa :max ký tự',
            'email' => ' :attribute không đúng định dạng',
            'unique' => ' :attribute đã tồn tại'
        ];
        $validator = Validator::make(
            $input,
            $rules,
            $message
        );
        if ($validator->fails()) {
            $arr = [
                'success' => false,
                'message' => 'Thêm mới không thành công',
                'error' => $validator->errors()
            ];
            return response()->json($arr, 500);
        }
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        $arr = [
            'status' => true,
            'message' => 'Đã thêm mới người dùng thành công',
            'data' => $user
        ];
        return response()->json($arr, 201);
    }
    function update($id, Request $request)
    {
        $user = User::find($id);
        User::where('id', $id)->update([
            'name' => $request->input('name') ? $request->input('name') : $user->name,
            'password' => $request->input('password') ? Hash::make($request->input('password')) : $user->password,
        ]);
        $arr = [
            'success' => true,
            'message' => 'Update người dùng thành công',
        ];
        return response()->json($arr, 200);
    }
    function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        $arr = [
            'status' => true,
            'message' => 'Người dùng đã được xóa',
            'data' => [],
        ];
        return response()->json($arr, 200);
    }
}
