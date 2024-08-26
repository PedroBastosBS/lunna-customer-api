<?php

namespace App\Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email:rfc,dns|unique:users',
            'phone' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ];
    }
    
    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Nome é obrigatório',
            'email.required' => 'Email é obrigatório',
            'email.unique'=> 'Email já existe !',
            'phone.required' => 'Celular é obrigatório',
            'password.confirmed' => 'Senhas não conferem',
            'password.required' => 'Senha é obrigatório',
            'password_confirmation.required' => 'Campo é obrigatório',
        ];
    }

    public function prepareForValidation()
    {
        if ($this->has('phone')) {
            $this->merge(['phone' => preg_replace('/[^0-9]/', '', $this->get('phone'))]);
        }
        if ($this->has('email')) {
            $this->merge(['email' => strtolower($this->get('email'))]);
        }
    }
}