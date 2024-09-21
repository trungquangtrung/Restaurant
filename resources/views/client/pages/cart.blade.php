@extends('client.layout.master')

@section('content')
    <div class="cart-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="cart-table-wrap">
                        <table class="cart-table">
                            <thead class="cart-table-head">
                                <tr class="table-head-row">
                                    <th class="product-image">Product Image</th>
                                    <th class="product-name">Name</th>
                                    <th class="product-price">Price</th>
                                    <th class="product-quantity">Quantity</th>
                                    <th class="product-total">Total</th>
                                    <th class="product-remove">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                              @php
                                  $grandTotal=0;
                              @endphp
                                @foreach ($cart as $productId => $item)
                                @php $grandTotal += $item['price'] * $item['qty']; @endphp
                                <tr class="table-body-row" id="item-{{ $productId }}">
                                    <td class="product-image">
                                        <a href="single-product.html">
                                            <img src="{{ asset('images/' . $item['image']) }}" width="100" height="50" alt="{{ $item['name'] }}">
                                        </a>
                                    </td>
                                    <td class="product-name">{{ $item['name'] }}</td>
                                    <td class="product-price">${{ number_format($item['price'], 2) }}</td>
                                    <td class="product-quantity"><input type="number" value="{{ $item['qty'] }}" min="1"> </td>
                                    <td class="product-total">${{ number_format($item['price'] * $item['qty'], 2) }}</td>
                                    <td class="product-remove">
                                        <form action="{{ route('client.cart.delete-product', ['productId' => $productId]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                    
                                </tr>
                                @endforeach
                                

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="total-section">
                        <table class="total-table">
                            <thead class="total-table-head">
                                <tr class="table-total-row">
                                    <th>Name</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $grandTotal = 0; // Initialize grand total
                                @endphp
                                @foreach ($cart as $productId => $item)
                                    <tr class="total-data">
                                        <td><strong>{{ $item['name'] }}</strong></td>
                                        <td>${{ number_format($item['price'], 2) }}</td>
                                    </tr>
                                    @php
                                        $grandTotal += $item['price'] * $item['qty']; // Update grand total
                                    @endphp
                                @endforeach
                            
                                <tr class="total-data">
                                    <td><strong>Total: </strong></td>
                                    <td>${{ number_format($grandTotal, 2) }}</td>
                                </tr>
                            </tbody>
                            
                        </table>
                        <div class="cart-buttons">
                            <form action="{{ route('client.checkout') }}" method="POST">
                                @csrf
                                <button type="submit" class="boxed-btn black">Check Out</button>
                            </form>
                        </div>
                        
                    </div>

                    <div class="coupon-section">
                        <h3>Apply Coupon</h3>
                        <div class="coupon-form-wrap">
                            <form action="index.html">
                                <p><input type="text" placeholder="Coupon"></p>
                                <p><input type="submit" value="Apply"></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end cart -->
@endsection

@section('my-js')
    <script>
        $('document').ready(function() {
            $('.icon_close').on('click', function(event) {

                var productId = $(this).data('product-id');

                var url = "{{ route('client.cart.delete-product') }}";
                url += '/' + productId;

                $.ajax({
                    method: "GET", //method of form
                    url: url, //action of form
                    success: function(response) {
                        $('tr#item-' + productId).empty();

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
