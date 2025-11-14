<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAuctionRequest extends FormRequest {
    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'seller_name'   => ['required','string','max:255'],
            'description'   => ['required','string'],
            'initial_price' => ['required','numeric','min:0'],
            'scheduled_at'  => ['required','date'],
            "end_at" => ["required", "date", "after:scheduled_at"]
        ];
    }
}
