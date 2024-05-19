<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    //
    function index(Request $request)
    {
        $keyword = "";
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
        }
        $product = Product::with('category_product')->where('product_name', 'LIKE', "%{$keyword}%")->orderBy('id', 'DESC')->paginate(10);
        $arr = [
            'status' => true,
            'message' => 'Danh sách người dùng',
            'data' => $product
        ];
        return response()->json($arr, 200);
    }
    function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required',
            'price' => 'required',
            'product_desc' => 'required',
            'product_detail' => 'required',
            'category_product_id' => 'required',
            'thumbnail' => 'required',
        ]);

        if ($validator->fails()) {
            $arr = [
                'success' => false,
                'message' => 'Thêm mới không thành công',
                'error' => $validator->errors()
            ];
            return response()->json($arr, 500);
        }
        $input = $request->all();
        if ($request->hasFile('thumbnail')) {
            $image = $request->thumbnail;

            $fileName = $image->getClientOriginalName();
            // $destinationPath = public_path($fileName);
            $image->move('uploads/product', $fileName);
            $thumbnail = 'public/uploads/product/' . $fileName;
            $input['thumbnail'] = $thumbnail;
        }
        if ($input['category_product_id'] == 0) {
            $arr = [
                'success' => false,
                'message' => 'Thêm mới không thành công vì chưa chọn danh mục sản phẩm',
            ];
            return response()->json($arr, 500);
        }
        $product = Product::create($input);
        $arr = [
            'status' => true,
            'message' => 'Đã thêm mới sản phẩm thành công',
            'data' => $product
        ];
        return response()->json($arr, 201);
    }
    function delete($id)
    {
        $product = Product::find($id);
        $product->delete();
        $arr = [
            'status' => true,
            'message' => 'Đã xóa sản phẩm thành công'
        ];
        return response()->json($arr, 200);
    }
    function update($id, Request $request)
    {
        $product = Product::find($id);
        $input = $request->all();
        if ($request->hasFile('thumbnail')) {
            // $product_image_old = $product->thumbnail;
            // unlink($product_image_old);
            $image = $request->thumbnail;

            $fileName = $image->getClientOriginalName();
            // $destinationPath = public_path($fileName);
            $image->move('uploads/product', $fileName);
            $thumbnail = 'public/uploads/product/' . $fileName;
        }

        $product['product_name'] = $request->input('product_name');
        $product['product_desc'] = $request->input('product_desc');
        $product['thumbnail'] =  isset($thumbnail) ? $thumbnail : $product->thumbnail;
        $product['category_product_id'] = $request->input('category_product_id');
        $product['product_detail'] = $request->input('product_detail');
        $product['price'] = $request->input('price');
        $product['slug'] = $request->input('slug');
        $product['status'] = $request->input('status');

        $update = $product->save();

        $arr = [
            'status' => true,
            'message' => 'Đã cập nhật sản phẩm thành công',
        ];
        return response()->json($arr, 201);
    }
    function ProductDetail($slug)
    {
        $product = Product::where('slug', $slug)->first();

        return response()->json(
            [
                'status' => true,
                'message' => 'Chi tiết sản phẩm',
                'data' => $product,
            ]
        );
    }
    function ProductCategoryList ($slug){
       $product = Product::where('slug', $slug)->first();

       $productCategoryList = Product::where('category_product_id', $product->category_product_id)->get();

       return response()->json(
        [
            'status' => true,
            'message' => 'Sản phẩm cùng danh mục',
            'data' => $productCategoryList,
        ]
    );
    }
}
