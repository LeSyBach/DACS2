<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class ZaloPayService
{
    protected $config;

    public function __construct()
    {
        // Lấy cấu hình ZaloPay từ config/services.php
        $this->config = config('services.zalopay');
    }

    /**
     * Hàm tạo chữ ký HMAC SHA256 (MAC) cho yêu cầu ZaloPay.
     * Đây là bước bảo mật bắt buộc.
     * @param string $data Dữ liệu cần mã hóa
     * @param string $key Khóa bí mật (Key1 hoặc Key2)
     * @return string
     */
    private function createSignature($data, $key)
    {
        return hash_hmac("sha256", $data, $key);
    }

    /**
     * Gửi yêu cầu tạo giao dịch ZaloPay và lấy URL thanh toán.
     *
     * @param \App\Models\Order $order Đơn hàng đã được lưu trong DB
     * @return array|null Phản hồi JSON từ ZaloPay
     */
    public function createOrderPayment(Order $order): ?array
    {
        $appId = $this->config['app_id'];
        $key1 = $this->config['key1'];
        $time = round(microtime(true) * 1000); // Unix timestamp (milliseconds)
        $amount = $order->total_price; 
        
        // Tạo mã giao dịch ZaloPay DUY NHẤT (Thường kết hợp Order ID và thời gian)
        $appTransId = $order->id . '-' . $time; 

        // 1. Dữ liệu cần mã hóa (signature data string)
        $data = $appId . "|" . $appTransId . "|" . $this->config['merchant_id'] . "|" . $amount . "|" . $time . "|" . $this->config['callback_url'];
        
        // 2. Tạo chữ ký bảo mật (MAC)
        $signature = $this->createSignature($data, $key1);

        $params = [
            'app_id' => $appId,
            'app_user' => $order->customer_name ?? 'Khach_Hang',
            'app_time' => $time,
            'amount' => (int) $amount, // ZaloPay yêu cầu giá trị số nguyên
            'app_trans_id' => $appTransId,
            'embed_data' => json_encode(['order_id' => $order->id]), // Gửi Order ID của bạn để nhận lại trong Callback
            'item' => json_encode([]), 
            'description' => 'Thanh toán đơn hàng TechStore #' . $order->id,
            'bank_code' => '',
            'mac' => $signature, // Chữ ký bảo mật
            'call_back_url' => $this->config['callback_url'],
        ];

        try {
            // 3. Gửi yêu cầu đến ZaloPay
            $response = Http::post($this->config['create_order_url'], $params);
            
            return $response->json();
            
        } catch (\Exception $e) {
            Log::error('ZaloPay API Connection Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Xử lý xác nhận Callback từ ZaloPay.
     * (Hàm này sẽ được gọi bởi CheckoutController@handleZaloPayCallback)
     */
    public function verifyCallback($data, $mac)
    {
        $key2 = $this->config['key2'];
        
        // Tái tạo chữ ký bằng KEY2 để kiểm tra tính toàn vẹn và bảo mật
        $reSignature = $this->createSignature($data, $key2);

        if ($reSignature === $mac) {
            $dataArray = json_decode($data, true);
            
            return [
                'success' => true,
                'data' => $dataArray,
                'return_code' => $dataArray['return_code']
            ];
        }

        return [
            'success' => false,
            'message' => 'MAC mismatch (Chữ ký không khớp)',
            'return_code' => -1
        ];
    }
}