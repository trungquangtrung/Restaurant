@extends('admin.layout.master')

@section('content')
<div class="container">
    <h1>Tạo Mã Giảm Giá</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.coupons.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="code">Mã Giảm Giá</label>
            <input type="text" class="form-control" name="code" required>
        </div>
        <div class="form-group">
            <label for="discount">Giá Trị Giảm Giá</label>
            <input type="number" class="form-control" name="discount" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="type">Kiểu Giảm Giá</label>
            <select class="form-control" name="type" required>
                <option value="percentage">Phần trăm</option>
                <option value="fixed">Cố định</option>
            </select>
        </div>
        <div class="form-group">
            <label for="start_date">Ngày Bắt Đầu</label>
            <input type="date" class="form-control" name="start_date">
        </div>
        <div class="form-group">
            <label for="end_date">Ngày Kết Thúc</label>
            <input type="date" class="form-control" name="end_date">
        </div>
        <div class="form-group">
            <label for="usage_limit">Số Lần Sử Dụng</label>
            <input type="number" class="form-control" name="usage_limit">
        </div>
        <button type="submit" class="btn btn-primary">Tạo Coupon</button>
    </form>
</div>
@endsection
