<?php
/*
 * Copyright (c) 2024. Kinal Games, Inc. All Rights Reserved.
 */

declare(strict_types=1);

namespace App\Models\Traits;

trait HasBankingTransferQRCode
{
    public function generateQRCodeData(string $bankId, string $bankAccount, string $message, int $amount = 0): string
    {
        // Data ID + Data Len + Data Content
        $_prefix = '000201'.'010211'.'38'; // '38' => VietQR
        $GUID = '0010A000000727';
        $_accountNumberLength = sprintf('%02d', strlen($bankAccount));
        $_accountNumber = '01'.$_accountNumberLength.$bankAccount;
        $_acquirerIdLength = sprintf('%02d', strlen($bankId));
        $_acquirer = '00'.$_acquirerIdLength.$bankId;
        $_beneficiaryLen = sprintf('%02d', strlen($_acquirer.$_accountNumber));
        $_beneficiary = '01'.$_beneficiaryLen.$_acquirer.$_accountNumber;
        $_payType = '0208QRIBFTTA';

        $_prefixLen = sprintf('%02d', strlen($GUID.$_beneficiary.$_payType));
        $_prefix = $_prefix.$_prefixLen.$GUID.$_beneficiary.$_payType;

        $_paymentPurposeLen = sprintf('%02d', strlen($message));
        $_paymentPurpose = '08'.$_paymentPurposeLen.$message;
        $_additionDataLen = sprintf('%02d', strlen($_paymentPurpose));
        $_memo = '62'.$_additionDataLen.$_paymentPurpose;
        $_txCurrency = '5303704';
        if ($amount > 0) {
            $_payAmount = '54'; // id
            $_payAmountLen = sprintf('%02d', strlen((string) $amount));
            $_payAmount = $_payAmount.$_payAmountLen.$amount;
        } else {
            $_payAmount = '';
        }
        $_countryCode = '5802VN';
        $_data = $_prefix.$_txCurrency.$_payAmount.$_countryCode.$_memo;
        // id = 63, 04 = crc len
        $_crc = '63'.'04'.$this->crc16($_data.'6304');

        return $_data.$_crc;
    }

    private function crc16($data): string
    {
        $crc = 0xFFFF;
        for ($c = 0; $c < strlen($data); $c++) {
            $crc ^= ord($data[$c]) << 8;
            for ($i = 0; $i < 8; $i++) {
                if ($crc & 0x8000) {
                    $crc = ($crc << 1) ^ 0x1021;
                } else {
                    $crc = $crc << 1;
                }
            }
        }

        $hex = $crc & 0xFFFF;
        $hex = dechex($hex);

        return strtoupper($hex);
    }
}
