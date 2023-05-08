<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Spatie\Permission\Models\Role;

class RoleUpdateRequest extends FormRequest
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
        // $role_id=Role::findById($this->route('id'));
        return [
            'permissions'=>['sometimes'],
            'permissions.*'=>['exists:permissions,name'],
            'role'=>['sometimes','unique:roles,name','max:60'],
        ];
    }
}
