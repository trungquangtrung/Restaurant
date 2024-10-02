<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProductCategoryController extends Controller
{
    public function index()
    {
        // $itemPerPage = env('ITEM_PER_PAGE', 10);
        $itemPerPage = config('myconfig.my-app.my-config.my-pagination.item-per-page');

        $datas = DB::table('product_category')->paginate($itemPerPage);

        return view('admin.pages.product_category.index', ['datas' => $datas]);
    }
    public function create()
    {
        return view('admin.pages.product_category.create');
    }

    public function store(Request $request)
    {
        //B1 : Validate + Has error -> show error
        $request->validate([
            'name' => ['required', 'min:3', 'max:255'],
            'status' => ['required'],
        ], [
            'name.required' => 'Ten buoc phai nhap.',
            'name.min' => 'Ten it nhat 3 ky tu.',
            'name.max' => 'Ten nhieu nhat 10 ky tu.',
            'status.required' => 'Trang thai buoc phai nhap.'
        ]);

        //B2 : Receive data
        $name = $request->name;
        $status = $request->status;

        //B3: Empty Error -> Model -> insert -> DB
        //Query Builder
        $result = DB::table('product_category')->insert([
            'name' => $name,
            'status' => $status,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        //B4: Show thanh cong hay that bail
        //Flash message
        return redirect()->route('admin.product_category.index')->with('message', $result ? 'Thanh cong' : 'That bai');
    }

    public function destroy($id)
    {
        $result = DB::table('product_category')->where('id', '=', $id)->delete();

        return redirect()->route('admin.product_category.index')->with('message', $result ? 'Xoa thanh cong' : 'Xoa that bai');
    }

    public function detail($id)
    {
        $data = DB::table('product_category')->where('id', '=', $id)->first();

        if (!$data) {
            return redirect()->route('admin.product_category.index')->with('error', 'Danh mục không tồn tại.');
        }
    
        return view('admin.pages.product_category.detail', ['data' => $data]);
    }

    public function update(Request $request, $id)
    {
        $data = DB::table('product_category')->where('id', '=', $id)->first();
    
        // Kiểm tra nếu không tìm thấy danh mục
        if (!$data) {
            return redirect()->route('admin.product_category.index')->with('error', 'Danh mục không tồn tại.');
        }
    
        $request->validate([
            'name' => ['required', 'min:3', 'max:255'],
            'status' => ['required'],
        ], [
            'name.required' => 'Tên phải được nhập.',
            'name.min' => 'Tên ít nhất 3 ký tự.',
            'name.max' => 'Tên tối đa 255 ký tự.',
            'status.required' => 'Trạng thái phải được nhập.'
        ]);
    
        $result = DB::table('product_category')->where('id', '=', $id)->update([
            'name' => $request->name,
            'status' => $request->status
        ]);
    
        return redirect()->route('admin.product_category.index')->with('message', $result ? 'Cập nhật thành công' : 'Cập nhật thất bại');
    }


}
