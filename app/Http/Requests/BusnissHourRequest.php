<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class BusnissHourRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(){
        $data=array_values($this->all()['data']);
        foreach($data as $index=>$day){
            if(!isset($day['off'])){
                $data[$index]['off']=false;
                continue;
            }
            $data[$index]['off']=!!$data[$index]['off'];
        }
        $this->replace([
            'data'=>$data
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [

            'data'=>['required','array','size:7'],
            'data.*.day'=>['required',],
            'data.*.from'=>['required','date_format:H:i:s'],
            'data.*.to'=>['required','date_format:H:i:s'],
            'data.*.step'=>['required','integer','min:1'],
            'data.*.off'=>['required','boolean'],
            
            //
        ];
    }

    public function failedValidation(ValidationValidator $validator){
        dd($validator->errors());
    }
}
