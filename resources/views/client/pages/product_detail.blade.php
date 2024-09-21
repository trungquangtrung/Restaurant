@extends('client.layout.master')

@section('content')
    <!-- single product -->
    <div class="single-product mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="single-product-img">
                        <a href="single-product.html"><img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}"
                                width="100" height="100"></a>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="single-product-content">
                        <h3>{{ $product->name }}</h3>
                        <p class="product-price">${{ $product->price }}</p>
                        <p>{{ $product->short_description }}</p>
                        <div class="single-product-form">
                            <form action="index.html">
                                <input type="number" id="product-qty" placeholder="0" min="1">
                            </form>
                            <li data-product-id="{{ $product->id }}" class="button-add-to-cart"><a href="cart.html"
                                    class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a></li>
                        </div>
                        <ul class="product-share">
                            <li><a href=""><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href=""><i class="fab fa-twitter"></i></a></li>
                            <li><a href=""><i class="fab fa-google-plus-g"></i></a></li>
                            <li><a href=""><i class="fab fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end single product -->
@endsection

@section('my-js')
    <script>
        $('document').ready(function() {
            $('.button-add-to-cart').on('click', function(event) {
                var productId = $(this).data('product-id');
                event.preventDefault();

                var qty = $('.pro-qty #product-qty').val();

                var url = $(this).data('url');
                url += '/' + qty;

                $.ajax({
                    method: "GET", //method of form
                    url: url, //action of form
                    success: function(response) {
                        alert(response.message);
                    },
                    fail: (function() {
                        alert("error");
                    }),
                    statusCode: {
                        401: function() {
                            window.location.href = "{{ route('login') }}"
                        }
                    }
                });
            });
        });
    </script>
@endsection
