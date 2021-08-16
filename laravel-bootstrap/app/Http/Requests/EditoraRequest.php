<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditoraRequest extends FormRequest
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
            'nome'        => 'required|max:60',
        ];
    }
	/**
	 * Get the error messages for the defined validation rules.
	 *
	 * @return array
	 */	
	public function messages()
	{
		return [
			'nome.required' => 'o campo nome é requerido',
			'nome.max' => 'O campo nome pode ter no máximo 60 caracteres',
		];
	}	
}
