<?php

namespace Database\Seeders;

use App\Enum\BankProvider;
use App\Enum\PaymentMethodStatus;
use App\Enum\PaymentMethodType;
use App\Enum\ProductCode;
use App\Models\PaymentMethod;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::firstOrCreate([
            'code' => ProductCode::POKEMON,
            'name' => 'Pocket Awakening',
            'description' => 'Pocket Awakening là một tựa game nhập vai chiến thuật hấp dẫn, nơi bạn sẽ hóa thân thành một Huấn Luyện Viên tài ba trong thế giới kỳ ảo đầy những sinh vật huyền bí.',
            'metadata' => [
                'developers' => 'Kinal Games',
            ],
        ]);
        PaymentMethod::firstOrCreate(
            [
                'name' => 'Ngân hàng Vietcombank',
                'code' => BankProvider::MB,
                'type' => PaymentMethodType::BANK_TRANSFER,
                'metadata' => [
                    'bank_id' => '970422',
                    'account_number' => '0507200328888',
                    'mobile_account_number' => '0327496995',
                    'account_name' => 'Phạm Quang Minh',
                ],
                'status' => PaymentMethodStatus::ACTIVE,
            ],
        );
    }
}
