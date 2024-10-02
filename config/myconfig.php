<?php
    return [
        'my-app' => [
            'my-config' => [
                'my-pagination' => [
                    'item-per-page' => env('ITEM_PER_PAGE', 5+10-5)
                ]
            ]
        ],
        'vnpay' => [
            'vnp_tmn_code' => env('VNP_TMP_CODE','PUEN5D41'),
            'vnp_hash_secret' => env('VNP_HASH_SECRET','HOTFMHEKKTGITZXOWUHWZRDRHVSUEXXG'),
            'vnp_url' => "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html",
            'vnp_return_url' => env('VNP_RETURN_URL','http://localhost:8080/vnpay/callback'),
            'vnp_api_url' => "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html",
            'api_url' => "https://sandbox.vnpayment.vn/merchant_webapi/api/transaction"
        ]

    ];
?>
