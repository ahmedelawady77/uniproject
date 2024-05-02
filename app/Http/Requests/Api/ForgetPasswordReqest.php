<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class ForgetPasswordReqest extends FormRequest
{

    protected function failedValidation(Validator $validator)
    {
        if ($validator->errors()->get('email')){
            $error = $validator->errors()->get('email')[0];
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
            'email' => 'required|email|exists:userapps,email',
        ];
    }
}
