<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreRequest;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $sort = $request->sort ?? 'oldest';

        $sortBy = ['created_at' , 'asc'];
        $sortBy = match($sort){
            'oldest' => ['created_at', 'asc'],
            'latest' => ['created_at', 'desc'],
            'price_low_to_high' => ['price', 'asc'],
            'price_high_to_low' => ['price', 'desc']
        };

        $itemPerPage = config('myconfig.my-app.my-config.my-pagination.item-per-page');

        //Query Builder
        // SELECT p.*, pc.name as 'product_category_name'
        // FROM `product` p
        // LEFT JOIN `product_category` pc ON p.product_category_id = pc.id;
        // if(is_null($keyword)){
        //     $datas = DB::table('product')
        //             ->leftJoin('product_category', 'product.product_category_id', '=', 'product_category.id')
        //             ->orderBy($sortBy[0], $sortBy[1])
        //             ->select('product.*', DB::raw('product_category.name as product_category_name'))
        //             ->paginate($itemPerPage);
        // }else{
        //     $datas = DB::table('product')
        //         ->leftJoin('product_category', 'product.product_category_id', '=', 'product_category.id')
        //         ->orderBy($sortBy[0], $sortBy[1])
        //         ->select('product.*', DB::raw('product_category.name as product_category_name'))
        //         ->where('name', 'like' , "%$keyword%")
        //         ->paginate($itemPerPage);
        // }

        //Eloquent
        if(is_null($keyword)){
            $datas = Product::with('productCategory')->orderBy($sortBy[0], $sortBy[1])->paginate($itemPerPage);
        }else{
            $datas = Product::with('productCategory')->where('name', 'like' , "%$keyword%")->orderBy($sortBy[0], $sortBy[1])->paginate($itemPerPage);
        }

        return view('admin.pages.product.index', ['datas' => $datas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productCategories = DB::table('product_category')->where('status', 1)->get();

        return view('admin.pages.product.create', ['productCategories' => $productCategories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        //Eloquent -> Model -> Fillable
        $file = $request->file('image');

        $originName = $file->getClientOriginalName();

        $fileName = pathinfo($originName, PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $fileName = $fileName . '_' . uniqid() . '.' . $extension;

        $file->move(public_path('images'), $fileName);

        $result = Product::create(
            [
                'name' => $request->name,
                'price' => $request->price,
                'qty'  => $request->qty,
                'description' => $request->description,
                'status' => $request->status,
                'product_cate$fileNamegory_id' => $request->productCategoryId,
                'image' => $fileName,
                'slug' => $request->slug
            ]
        );

        return redirect()->route('admin.product.index')->with('message', $result ? 'Thanh cong' : 'That bai');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $result = $product->delete();
        return redirect()->route('admin.product.index')->with('message', $result ? 'Thanh cong' : 'That bai');
    }

    public function makeSlug(Request $request){
        //use Illuminate\Support\Str;
        return response()->json(['name' => Str::slug($request->name)]);
    }
}
