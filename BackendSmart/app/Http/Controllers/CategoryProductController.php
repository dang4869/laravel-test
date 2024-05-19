<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryProductController extends Controller
{
    //

    function index()
    {
        // $categoryproducts = CategoryProduct::where('category_parent',0)->orderBy('id','DESC')->get();
        // $category_product = CategoryProduct::all();
        // $categoryproducts_all = CategoryProduct::paginate(10);
        $category = $this->getCategoryProduct();

        return response()->json([
            'status' => true,
            'message' => 'Danh sách danh mục sản phẩm',
            'data' => $category
        ]);
    }
    function getCategoryProduct()
    {
        $categoryproducts = CategoryProduct::all();
        $listCategory = [];
        CategoryProduct::recursive($categoryproducts, $parents = 0, $level = 1, $listCategory);
        return $listCategory;
    }
    function add(Request $request)
    {
        $input = $request->all();
        $rules = [
            'category_name' => 'required|min:6',
            'slug' => 'required|min:6',
            'category_parent' => 'required'
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
        $category = CategoryProduct::create([
            'category_name' => $request->input('category_name'),
            'slug' => $request->input('slug'),
            'category_parent' => $request->input('category_parent'),
        ]);
        $arr = [
            'status' => true,
            'message' => 'Đã thêm mới danh mục sản phẩm thành công',
            'data' => $category
        ];
        return response()->json($arr, 201);
    }
    function update(Request $request, $id)
    {
        $category = CategoryProduct::find($id);
        CategoryProduct::where('id', $id)->update([
            'category_name' => $request->input('category_name') ? $request->input('category_name') : $category->category_name,
            'slug' => $request->input('slug') ? $request->input('slug') : $category->slug,
            'category_parent' => $request->input('category_parent') ? $request->input('category_parent') : $category->category_parent,
        ]);
        return $request->all();
        $arr = [
            'success' => true,
            'message' => 'Cập nhật danh mục sản phẩm thành công',
        ];
        return response()->json($arr, 200);
    }
    function delete($id)
    {
        $category = CategoryProduct::find($id);
        $count = CategoryProduct::where('category_parent',$id)->count();
        if($count>0){
            $arr = [
                'status' => false,
                'message' => 'Bạn cần xóa danh mục con của nó trước',
            ];
            return response()->json($arr, 401);
        }
        $category->delete();
        $arr = [
            'status' => true,
            'message' => 'Danh mục sản phẩm đã được xóa',
            'data' => [],
        ];
        return response()->json($arr, 200);
    }
}
