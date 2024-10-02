@extends('client.layout.master')

@section('content')
 <!--PreLoader-->
 <div class="loader">
    <div class="loader-inner">
        <div class="circle"></div>
    </div>
</div>
<!--PreLoader Ends-->
<!-- Checkout Section Begin -->
<section class="checkout spad">
    <div class="container">
        <div class="checkout__form">
            <h4>Chi tiết thanh toán</h4>
            <form action="{{ route('client.placeOrder') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-8 col-md-6">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="checkout__input">
                                    <p>Họ và Tên<span>*</span></p>
                                    <input type="text" name="full_name" value="{{ Auth::user()->name }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="checkout__input">
                            <p>Địa Chỉ<span>*</span></p>
                            <input type="text" name="address" placeholder="Địa Chỉ" class="checkout__input__add" required>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="checkout__input">
                                    <p>Số Điện Thoại<span>*</span></p>
                                    <input type="text" name="phone" value="{{ Auth::user()->phone }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="checkout__input">
                            <p>Ghi chú<span>*</span></p>
                            <input type="text" name="notes" placeholder="Ghi chú">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="checkout__order">
                            <h4>Đơn hàng của bạn</h4>
                            <div class="checkout__order__products">Tổng Sản Phẩm</div>
                            <ul>
                                @php $total = 0 @endphp
                                @foreach ($cart as $item)
                                    @php $total += $item['price'] * $item['qty'] @endphp
                                    <li>{{ $item['name'] }} <span>${{ number_format($item['price'] * $item['qty'], 2) }}</span></li>
                                @endforeach
                            </ul>
                            <div class="checkout__order__subtotal">Tổng Cộng <span>${{ number_format($total, 2) }}</span></div>
                            
                            @if (session('coupon'))
                                <div class="checkout__order__discount">Giảm Giá <span>-${{ number_format(session('coupon.discount'), 2) }}</span></div>
                                <div class="checkout__order__total">Tổng <span>${{ number_format($total - session('coupon.discount'), 2) }}</span></div>
                            @else
                                <div class="checkout__order__total">Tổng <span>${{ number_format($total, 2) }}</span></div>
                            @endif
                            
                            <div class="checkout__input__checkbox">
                                <label for="VNBANK">
                                    Thanh toán qua thẻ ATM/Tài khoản nội địa
                                    <input type="radio" id="VNBANK" name="bank_code" value="VNBANK" required>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="checkout__input__checkbox">
                                <label for="INTCARD">
                                    Thanh toán qua thẻ quốc tế
                                    <input type="radio" id="INTCARD" name="bank_code" value="INTCARD" required>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="checkout__input__checkbox">
                                <label for="paypal">
                                    COD (Cash on delivery)
                                    <input type="radio" id="paypal" name="bank_code" value="COD" required>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <button type="submit" class="site-btn">ĐẶT HÀNG</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- Checkout Section End -->

@endsection
