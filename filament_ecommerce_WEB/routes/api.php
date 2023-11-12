<?php

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('slideList', function () {
    $products = Post::inRandomOrder()->limit(5)->get();

    $baseUrl = "http://192.168.1.2:8000/storage"; // Replace this with your actual base URL

// Add the base URL to the image field
    $modifiedProducts = collect($products)->map(function ($product) use ($baseUrl) {
        $product['Image'] = $baseUrl . '/' . $product['Image'];
        $product['thumbnail'] = $baseUrl . '/' . $product['thumbnail'];
        return $product;
    });

    return response()->json([
        'msg' => 'success',
        'data' => $modifiedProducts,
    ]);
});

Route::get('categoryList', function () {
    $products = Category::inRandomOrder()->get();

    $baseUrl = "http://192.168.1.2:8000/storage"; // Replace this with your actual base URL

    // Add the base URL to the image field
    $modifiedProducts = collect($products)->map(function ($product) use ($baseUrl) {
        $product['icon'] = $baseUrl . '/' . $product['icon'];

        return $product;
    });

  
    return response()->json([
        'msg' => 'success',
        'data' => $modifiedProducts,
    ]);
});
Route::get('popular', function(){
    $lastFourPosts = Post::latest()->limit(4)->with('category')->get();

    $baseUrl = "http://192.168.1.2:8000/storage"; // Replace this with your actual base URL

    // Add the base URL to the image field
    $modifiedProducts = collect($lastFourPosts)->map(function ($product) use ($baseUrl) {
        $product['Image'] = $baseUrl . '/' . $product['Image'];

        return $product;
    });

    return response()->json([
        'msg' => 'success',
        'data' => $modifiedProducts,
    ]);
});

Route::get('special', function(){
    $lastFourPosts = Post::with('category')->get();

    $baseUrl = "http://192.168.1.2:8000/storage"; // Replace this with your actual base URL

    // Add the base URL to the image field
    $modifiedProducts = collect($lastFourPosts)->map(function ($product) use ($baseUrl) {
        $product['Image'] = $baseUrl . '/' . $product['thumbnail'];

        return $product;
    });

    return response()->json([
        'msg' => 'success',
        'data' => $modifiedProducts,
    ]);
});

Route::get('ProductDetailsById/{id}', function($id){

    $post1=Post::with('category')->where('id',$id)->get();
    $baseUrl = "http://192.168.1.2:8000/storage"; // Replace this with your actual base URL

    // Add the base URL to the image field
    $modifiedProducts = collect($post1)->map(function ($product) use ($baseUrl) {
        $product['thumbnail'] = $baseUrl . '/' . $product['thumbnail'];
        $product['Image'] = $baseUrl . '/' . $product['Image'];

        return $product;
    });

    return response()->json([
        'msg' => 'success',
        'data' => $modifiedProducts,
    ]);
});
