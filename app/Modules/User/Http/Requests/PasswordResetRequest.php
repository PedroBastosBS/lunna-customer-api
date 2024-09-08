<?php

namespace App\Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordResetRequest extends FormRequest
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
            'email' => 'required|email',
            'token' => 'sometimes|required',
            'password' => 'sometimes|required|confirmed|min:8',
            'password_confirmation' => 'sometimes|required',
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
            'email.required' => 'E-mail é obrigatório',
            'email.email' => 'E-mail é inválido !',
            'token.required' => 'É necessário ter um token pra recuperar a senha!',
            'password.required' => 'Campo obrigatorio !',
            'password.confirmed' => 'Confirme a senha.',
            'password.min' => 'Deve ter pelo menos 8 digitos.',
        ];
    }

    public function prepareForValidation()
    {
        if ($this->has('document')) {
            $this->merge(['document' => preg_replace('/[^0-9]/', '', $this->get('document'))]);
        }
    }
}