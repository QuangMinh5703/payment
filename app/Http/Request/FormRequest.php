<?php

namespace App\Http\Request;

use App\Contract\IKinalFormRequest;
use App\Exception\ValidationException;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Str;

abstract class FormRequest extends BaseFormRequest implements IKinalFormRequest
{
    const KG_PRODUCT_ID = 'KG-Product-ID';

    protected ?Product $product = null;

    /**
     * Handle a failed validation attempt.
     *
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new ValidationException($validator->errors());
    }
    function array_keys_to_snake(array $array, bool $recursive = true): array
    {
        $data = [];
        foreach ($array as $key => $value) {
            $key = Str::snake($key);
            if (is_array($value) && $recursive) {
                $data[$key] = $this->array_keys_to_snake($value, $recursive);
            } else {
                $data[$key] = $value;
            }
        }

        return $data;
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);
        if (is_array($data)) {
            return $this->array_keys_to_snake($data);
        }

        return $data;
    }

    public function getProductId(): int
    {
        return (int) $this->header(self::KG_PRODUCT_ID);
    }

    /**
     * Get the "after" validation callables for the request.
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                $productId = $this->getProductId();
                $product = Product::find($productId);
                $this->product = $product;
                if (! $product) {
                    $validator->errors()->add(
                        'product_channel_id',
                        __('Product channel not found.'));
                }
            },
        ];
    }
}
