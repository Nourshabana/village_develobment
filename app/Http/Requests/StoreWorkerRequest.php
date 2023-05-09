<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkerRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'=>['required','string'],
            'jobname'=>['required','string'],
            'address'=>['required'],
            'phone'=>['sometimes'],
            'email'=>['required','unique:users,email'],
            'password'=>['required','min:6'],
            'worktime'=>['required'],
            'photo'=>['sometimes','max:2000','mimes:png,jpg']
        ];
    }
}
