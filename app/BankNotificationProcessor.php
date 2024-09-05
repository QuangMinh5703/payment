<?php

namespace App;

class BankNotificationProcessor
{
    public function processNotification(string $notification, float $expectedAmount, string $expectedCode)
    {
        // Tách thông báo thành các phần
        $parts = explode('|', $notification);

        // Tìm phần chứa thông tin giao dịch (GD:)
        $transactionPart = array_filter($parts, function($part) {
            return strpos($part, 'GD:') !== false;
        });

        if (empty($transactionPart)) {
            return false; // Không tìm thấy thông tin giao dịch
        }

        $transactionInfo = trim(current($transactionPart));

        // Lấy số tiền từ thông tin giao dịch
        preg_match('/\+(\d+)\s*VND/', $transactionInfo, $matches);

        if (empty($matches)) {
            return false; // Không tìm thấy số tiền
        }

        $amount = floatval($matches[1]);

        // Tìm phần chứa nội dung chuyển khoản (ND:)
        $contentPart = array_filter($parts, function($part) {
            return strpos($part, 'ND:') !== false;
        });

        if (empty($contentPart)) {
            return false; // Không tìm thấy nội dung chuyển khoản
        }

        $content = trim(str_replace('ND:', '', current($contentPart)));

        // Loại bỏ các ký tự không mong muốn (như '}')
        $content = preg_replace('/[^\w]/', '', $content);

        // Kiểm tra số tiền và nội dung
        if ($amount == $expectedAmount && $content == $expectedCode) {
            return true; // Giao dịch hợp lệ
        }

        return false; // Giao dịch không hợp lệ
    }
}
