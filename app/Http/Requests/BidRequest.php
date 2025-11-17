<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BidRequest extends FormRequest {
    public function rules(): array {
        return [
            'amount' => 'required|numeric|min:1',
            "dni" => "required|string|min:6|max:9"
        ];
    }
}
