<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    function getPhone()
    {
        $subCategoryPhone = CategoryProduct::where('category_parent', 2)->get();
        $sub_array_phone = array();
        foreach ($subCategoryPhone as $sub_phone) {
            $sub_array_phone[] = $sub_phone->id;
        }
        $product_phone = Product::whereIn('category_product_id', $sub_array_phone)->where('status', 0)->orderby('id', 'DESC')->limit(8)->get();
        return response()->json([
            'status' => true,
            'message' => 'Danh điện thoại',
            'data' => $product_phone
        ]);
    }
    function getLaptop()
    {
        $subCategoryLaptop = CategoryProduct::where('category_parent', 3)->get();
        $sub_array_laptop = array();
        foreach ($subCategoryLaptop as $sub_laptop) {
            $sub_array_laptop[] = $sub_laptop->id;
        }
        $product_laptop = Product::whereIn('category_product_id', $sub_array_laptop)->where('status', 0)->orderby('id', 'DESC')->limit(8)->get();
        return response()->json([
            'status' => true,
            'message' => 'Danh điện laptop',
            'data' => $product_laptop
        ]);
    }
    function getProductNew()
    {
        $productNew = Product::where('status', 0)->orderby('id', 'DESC')->limit(8)->get();
        return response()->json([
            'status' => true,
            'message' => 'Danh sản phẩm mới nhất',
            'data' => $productNew
        ]);
    }
    function getProductOutstanding()
    {
        $productOutstanding = Product::where('status', 0)->where('properties', 1)->orderby('id', 'DESC')->limit(8)->get();
        return response()->json([
            'staus' => true,
            'message' => 'Danh sách sản phẩm nổi bật',
            'data' => $productOutstanding
        ]);
    }
}
