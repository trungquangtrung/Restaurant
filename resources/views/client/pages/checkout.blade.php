@extends('client.layout.master')

@section('content')
    <!-- check out section -->
    <div class="checkout-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="checkout-accordion-wrap">
                        <div class="accordion" id="accordionExample">
                            <div class="card single-accordion">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse"
                                            data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Billing Address
                                        </button>
                                    </h5>
                                </div>

                                <!-- Form starts here -->
                                <form action="{{ route('client.checkout') }}" method="POST">
                                    @csrf
                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                        data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="billing-address-form">
                                                <p><input type="text" name="name" placeholder="Name" required></p>
                                                <p><input type="email" name="email" placeholder="Email" required></p>
                                                <p><input type="text" name="address" placeholder="Address" required></p>
                                                <p><input type="tel" name="phone" placeholder="Phone" required></p>
                                                <p>
                                                    <textarea name="bill" id="bill" cols="30" rows="10" placeholder="Say Something"></textarea>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                            </div>

                            <div class="card single-accordion">
                                <div class="card-header" id="headingTwo">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                            data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Shipping Address
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="shipping-address-form">
                                            <p>Your shipping address form is here.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card single-accordion">
                                <div class="card-header" id="headingThree">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                            data-target="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree">
                                            Card Details
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="card-details">
                                            <p>Your card details go here.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="order-details-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Your Order Details</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody class="order-details-body">
                                <tr>
                                    <td>Product</td>
                                    <td>Total</td>
                                </tr>                   
                                @php $total = 0 @endphp
                                @foreach ($cart as $item)
                                    @php $total += $item['price'] * $item['qty'] @endphp
                                    <tr>
                                        <td>{{ $item['name'] }}</td>
                                        <td>${{ $item['price'] * $item['qty'] }}</td>
                                    </tr>
                                @endforeach   
                                <tr>
                                    <td>Total</td>
                                    <td>${{ $total }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="checkout__input__checkbox">
                            <label for="VNBANK">
                                Thanh toán qua thẻ ATM/Tài khoản nội địa
                                <input type="radio" id="VNBANK" name="bank_code" value="VNBANK">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="checkout__input__checkbox">
                            <label for="INTCARD">
                                Thanh toán qua thẻ quốc tế
                                <input type="radio" id="INTCARD" name="bank_code" value="INTCARD">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="checkout__input__checkbox">
                            <label for="COD">
                                COD (Cash on delivery)
                                <input type="radio" id="COD" name="bank_code" value="COD">
                                <span class="checkmark"></span>
                            </label>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="boxed-btn">Place Order</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end check out section -->
@endsection
