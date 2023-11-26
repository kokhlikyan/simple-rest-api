<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class LoginService
{
    public function validator(array $data): \Illuminate\Validation\Validator
    {
        return Validator::make($data, [
            'email' => ['required', 'email', Rule::exists('users', 'email')],
            'password' => ['required', 'string', 'min:6'],
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function handle(array $data): string
    {
        $user = User::query()->where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'message' => ['Invalid credentials'],
            ]);
        }
        return $user->createToken($user->email)->plainTextToken;
    }
}
