<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'mode' => ['required', 'in:b2c,b2b'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $productId = $this->input('product_id');
            $quantity = (int) $this->input('quantity');
            $mode = $this->input('mode');

            if ($mode === 'b2b' && $productId) {
                $product = Product::find($productId);
                if ($product && $quantity < $product->moq) {
                    $validator->errors()->add(
                        'quantity',
                        "Minimum Order Quantity (MOQ) for B2B mode is {$product->moq} units."
                    );
                }
            }
        });
    }
}
