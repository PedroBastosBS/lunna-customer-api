<?php

namespace App\Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompleteResgistrationRequest extends FormRequest
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
            'type' => 'required|integer|in:1,2',
            'document' => [
                'required',
                'string',
                'regex:/^\d{3}\.?\d{3}\.?\d{3}-?\d{2}$/',
                'unique:users,document,' . auth()->id(),
            ],
            'street' => 'required',
            'district' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zipcode' => [
                'required',
                'string',
                'regex:/^\d{5}-?\d{3}$/'
            ],
            'creci' => [
                'sometimes',
                'string',
            ],
            'description' => 'sometimes|required|string',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
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
            'document.required' => 'Documento é obrigatório',
            'document.regex' => 'Documento é inválido !',
            'document.unique' => 'Documento já existe !',
            'type.required' => 'Campo é obrigatório',
            'type.integer' => 'Campo deve ter um valor numerico',
            'type.in' => 'Campo é deve ser entre 1 e 2',
            'street.required' => 'Campo é obrigatório',
            'district.required' => 'Campo é obrigatório',
            'city.required' => 'Campo é obrigatório',
            'state.required' => 'Campo é obrigatório',
            'zipcode.required' => 'Campo é obrigatório',
            'zipcode.regex' => 'CEP informado é inválido !',
            'creci.required' => 'Campo é obrigatório',
            'creci.regex' => 'CRECI informado é inválido!',
            'description.required' => 'Campo é obrigatório',
            'description.string' => 'Campo deve ser um texto !',
            'profile.image' => 'O arquivo deve ser uma imagem',
            'profile.mimes' => 'A imagem deve ser do tipo JPEG, PNG, JPG ou GIF',
            'profile.max' => 'A imagem é muito grande. Tamanho máximo permitido é de 2MB'
        ];
    }

    public function prepareForValidation()
    {
        if ($this->has('document')) {
            $this->merge(['document' => preg_replace('/[^0-9]/', '', $this->get('document'))]);
        }
    }
}