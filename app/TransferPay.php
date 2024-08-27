<?php

namespace App;

use App\Contract\ITransferPay;


final class TransferPay implements ITransferPay
{
    public function paymentMemoForOrder(): string
    {
        // Tạo 2 ký tự ngẫu nhiên cho prefix
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $prefix = $characters[rand(0, 25)] . $characters[rand(0, 25)];

        // Lấy thời gian hiện tại dưới dạng microseconds
        $timestamp = microtime(true);

        // Chuyển đổi thành chuỗi số và loại bỏ dấu chấm
        $numericPart = str_replace('.', '', (string)$timestamp);

        // Lấy 6 chữ số cuối cùng để đảm bảo tổng độ dài là 8
        $numericPart = substr($numericPart, -6);

        // Kết hợp prefix và phần số
        return $prefix . $numericPart;
    }
}
