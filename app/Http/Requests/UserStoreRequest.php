<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Carbon\Carbon;
use App\Models\Token;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $token = request()->bearerToken();
        
        if ($token) {

            $api_token = Token::where('token', '=', $token)->
            whereNull('last_used_at')
            ->where('expires_at', '>=', Carbon::now()->format('Y-m-d H:i:s') )->get()->first();

            if (isset($api_token->token)) {
                
                $api_token->last_used_at = Carbon::now();
                $api_token->save();
                return true;
            }   

        }

        throw new HttpResponseException(response()->json([
                'success'   => false,
                'message'   => 'The token expired'
        ], 401));
       
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'        => 'required|string|min:2|max:60',
            'email'       => 'required|regex:/^\w+([-+.\']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/|unique:users,email',
            'phone'       => 'required|unique:users,phone|regex:/^(\+380[0-9]{9})$/',
            'position_id' => 'required|exists:positions,id',
            'photo'       => 'required|mimes:jpg,jpeg|dimensions:min_width=70,min_height=70|max:5120',
        ];
    }

    public function failedValidation(Validator $validator)
    {

        if (isset($validator->failed()['email']['Unique']) OR isset($validator->failed()['email']['Unique'])) {
            throw new HttpResponseException(response()->json([

                'success'   => false,
                'message'   => 'User with this phone or email already exist',
    
            ], 409));
        }

        throw new HttpResponseException(response()->json([

            'success'   => false,
            'message'   => 'Validation failed',
            'fails'      => $validator->errors()

        ], 422));
    }

}
