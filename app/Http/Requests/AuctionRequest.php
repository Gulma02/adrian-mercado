<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuctionRequest extends FormRequest {
    public function rules(): array {
        return [
            "seller_name" => "required|string|max:255",
            'description' => 'required|string|max:255',
            'initial_price' => 'required|numeric|min:1',
            "scheduled_at" => "required|date"
        ];
    }
}
