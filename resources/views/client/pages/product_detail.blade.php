@extends('client.layout.master')

@section('content')
<div class="product-detail mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-fluid">
            </div>
            <div class="col-md-7">
                <h3>{{ $product->name }}</h3>
                <p class="product-price">${{ $product->price }}</p>
                <p>{{ $product->short_description }}</p>
                <form action="{{ route('client.cart.add-product', ['productId' => $product->id]) }}" method="POST">
                    @csrf
                    <input type="number" name="qty" value="1" min="1" required>
                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                </form>
            </div>
        </div>
    </div>
</div>
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
