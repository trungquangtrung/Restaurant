@extends('client.layout.master')

@section('content')
 <!--PreLoader-->
 <div class="loader">
    <div class="loader-inner">
        <div class="circle"></div>
    </div>
</div>
<!--PreLoader Ends-->
    <div class="container mt-5">
        @if ($product)
        <!-- Single Product Section -->
        <div class="single-product mt-150 mb-150">
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        <div class="single-product-img">
                            <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="single-product-content">
                            <h3>{{ $product->name }}</h3>
                            <p class="price">Price: <strong>${{ number_format($product->price, 2) }}</strong></p>
                            <p>{!! $product->description !!}</p>

                            <!-- Button to add the current product to the cart -->
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
            <p class="text-center">Product not found.</p>
        @endif
    </div>

   
    
@endsection
