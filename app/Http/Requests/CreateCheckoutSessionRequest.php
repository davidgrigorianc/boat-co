<?php

namespace App\Http\Requests;

use App\Models\Boat;
use Illuminate\Foundation\Http\FormRequest;

class CreateCheckoutSessionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'boat_id' => 'required|exists:boats,id',
            'amount' => 'required|numeric|min:1',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $boat = Boat::find($this->boat_id);

            if (!$boat) {
                $validator->errors()->add('boat_id', 'Boat not found.');
                return;
            }

            if ($boat->price != $this->amount) {
                $validator->errors()->add('amount', 'Incorrect amount for this boat.');
            }
        });
    }
}
