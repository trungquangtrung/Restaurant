@extends('client.layout.master')

@section('content')
<!-- Begin display -->
<div class="container">
    <div class="header clearfix">
        <h3 class="text-muted">VNPAY RESPONSE</h3>
    </div>
    <div class="table-responsive">
        <div class="form-group">
            <label>Mã đơn hàng:</label>
            <label>{{ request()->get('vnp_TxnRef') }}</label>
        </div>
        <div class="form-group">
            <label>Số tiền:</label>
            <label>{{ number_format(request()->get('vnp_Amount') / 100, 0, ',', '.') }} VNĐ</label>
        </div>
        <div class="form-group">
            <label>Nội dung thanh toán:</label>
            <label>{{ request()->get('vnp_OrderInfo') }}</label>
        </div>
        <div class="form-group">
            <label>Mã phản hồi (vnp_ResponseCode):</label>
            <label>{{ request()->get('vnp_ResponseCode') }}</label>
        </div>
        
        <div class="form-group">
            <label>Mã Ngân hàng:</label>
            <label>{{ request()->get('vnp_BankCode') }}</label>
        </div>
        <div class="form-group">
            <label>Kết quả:</label>
            <label>
                @php
                    $vnp_HashSecret = config('myconfig.vnpay.vnp_hash_secret'); 
                    $vnpSecureHash = ''; 
                    $vnp_SecureHash = request()->get('vnp_SecureHash');
                   
                    $inputData = request()->except('vnp_SecureHash'); 
                    ksort($inputData);
                    $hashdata = http_build_query($inputData);
                    $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
                @endphp
                @if ($vnpSecureHash === $vnp_SecureHash)
                    @if (request()->get('vnp_ResponseCode') === '00')
                        <span style='color:blue'>GD Thành công</span>
                    @else
                        <span style='color:red'>GD Không thành công</span>
                    @endif
                @else
                    <span style='color:red'>Chữ ký không hợp lệ</span>
                @endif
            </label>
        </div>
    </div>
    <p>&nbsp;</p>
    <footer class="footer">
        <p>&copy; VNPAY {{ date('Y') }}</p>
    </footer>
</div>
@endsection
