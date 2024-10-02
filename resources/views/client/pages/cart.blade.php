@extends('client.layout.master')

@section('content')
<!-- PreLoader -->
<div class="loader">
    <div class="loader-inner">
        <div class="circle"></div>
    </div>
</div>
<!-- PreLoader Ends -->

<div class="cart-section mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="cart-table-wrap">
                    <table class="cart-table">
                        <thead class="cart-table-head">
                            <tr class="table-head-row">
                                <th class="product-image">Hình ảnh sản phẩm</th>
                                <th class="product-name">Tên sản phẩm</th>
                                <th class="product-price">Giá</th>
                                <th class="product-quantity">Số lượng</th>
                                <th class="product-total">Tổng</th>
                                <th class="product-remove">Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $grandTotal = 0;
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
                                    <td class="product-quantity"><input type="number" value="{{ $item['qty'] }}" min="1"></td>
                                    <td class="product-total">${{ number_format($item['price'] * $item['qty'], 2) }}</td>
                                    <td class="product-remove">
                                        <form action="{{ route('client.cart.delete-product', ['productId' => $productId]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Xóa</button>
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
                                <th>Tên</th>
                                <th>Giá</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart as $productId => $item)
                                <tr class="total-data">
                                    <td><strong>{{ $item['name'] }}</strong></td>
                                    <td>${{ number_format($item['price'], 2) }}</td>
                                </tr>
                            @endforeach
                        
                            <tr class="coupons">
                                <td><strong>Mã giảm giá: </strong></td>
                                <td>
                                    @if (session('coupon'))
                                        {{ session('coupon.code') }} - Giảm: ${{ number_format(session('coupon.discount'), 2) }}
                                    @else
                                        Chưa có mã giảm giá
                                    @endif
                                </td>
                            </tr>
                        
                            <tr class="total-data">
                                <td><strong>Tổng: </strong></td>
                                <td>
                                    @if (session('coupon'))
                                        ${{ number_format($grandTotal - session('coupon.discount'), 2) }}
                                    @else
                                        ${{ number_format($grandTotal, 2) }}
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="cart-buttons">
                        <form action="{{ route('client.checkout') }}" method="POST">
                            @csrf
                            <button type="submit" class="boxed-btn black">Thanh Toán</button>
                        </form>
                    </div>
                </div>

                <form id="coupon-form" method="POST" action="{{ route('apply.coupon') }}">
                    @csrf
                    <div class="form-group">
                        <label for="coupon-code">Nhập mã giảm giá:</label>
                        <input type="text" name="code" id="coupon-code" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Áp dụng</button>
                </form>
                
                <div id="coupon-message"></div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('coupon-form').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const couponMessage = document.getElementById('coupon-message');

        fetch(this.action, {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            couponMessage.textContent = data.message; 

            if (data.newTotal) {
                // Cập nhật tổng giá trị trên giao diện
                const totalElement = document.querySelector('.total-data td:last-child'); 
                totalElement.textContent = '$' + data.newTotal; 
            }
        })
        .catch(error => {
            console.error('Error:', error);
            couponMessage.textContent = 'Đã có lỗi xảy ra. Vui lòng thử lại.'; 
        });
    });

    // Cập nhật tổng giá khi thay đổi số lượng sản phẩm
    const quantityInputs = document.querySelectorAll('.product-quantity input');
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            const row = this.closest('tr');
            const price = parseFloat(row.querySelector('.product-price').textContent.replace('$', '').replace(',', ''));
            const quantity = parseInt(this.value);
            const newTotal = price * quantity;

            row.querySelector('.product-total').textContent = '$' + newTotal.toFixed(2);

            // Cập nhật tổng giá trị
            let grandTotal = 0;
            document.querySelectorAll('.product-total').forEach(total => {
                grandTotal += parseFloat(total.textContent.replace('$', '').replace(',', ''));
            });

            const totalElement = document.querySelector('.total-data td:last-child');
            totalElement.textContent = '$' + grandTotal.toFixed(2);
        });
    });
</script>

@endsection
