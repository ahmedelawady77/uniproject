<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest
{

    protected function failedValidation(Validator $validator)
    {
        $error = "Error";
        if ($validator->errors()->get('name')){
            $error .= ' name';
        }
        if ($validator->errors()->get('email')){
            $error .= ' email';;
        }
        

        throw new HttpResponseException(response()->json([
            'Msg' => 'failled',
            'errors' => $error,
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }

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
            'name'=>"required",
            'email'=>"required|unique:userapps,email",
            'password'=>"required",
        ];
    }

}
