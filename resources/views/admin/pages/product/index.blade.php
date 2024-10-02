@extends('admin.layout.master')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Product List</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Product List</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                @if (Session::has('message'))
                                    <p class="alert alert-success">{{ Session::get('message') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Product List</h3><Br>
                                <div>
                                    <form action="{{ route('admin.product.index') }}" method="GET" role="form">
                                        <div class="form-group">
                                            <label for="keyword">Keyword</label>
                                            <input name="keyword" type="text" class="form-control" id="keyword"
                                                placeholder="Enter keyword" value="{{ request()->keyword ?? '' }}">

                                        </div>
                                        <div class="form-group">
                                            <label>Sort</label>
                                            <select name="sort" class="form-control">
                                                <option value="">---Please select---</option>
                                                <option {{ request()->sort === 'oldest' ? 'selected' : '' }} value="oldest">
                                                    Oldest</option>
                                                <option {{ request()->sort === 'latest' ? 'selected' : '' }} value="latest">
                                                    Latest</option>
                                                <option {{ request()->sort === 'price_low_to_high' ? 'selected' : '' }}
                                                    value="price_low_to_high">Price low to high</option>
                                                <option {{ request()->sort === 'price_high_to_low' ? 'selected' : '' }}
                                                    value="price_high_to_low">Price high to low</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </form>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datas as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->name }}</td>
                                                <td>{{ $data->price }}</td>
                                                <td>{{ $data->status ? 'Show' : 'Hide' }}</td>
                                                <td>
                                                    <form
                                                        action="{{ route('admin.product.destroy', ['product' => $data->id]) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger" type="submit">Delete</button>
                                                    </form>

                                                    <a class="btn btn-primary"
                                                        href="{{ route('admin.product_category.detail', ['id' => $data->id]) }}">Detail</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                {{ $datas->links() }}
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
