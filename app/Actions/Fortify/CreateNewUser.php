<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Referido;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    // CreateNewUser.php

    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        /*   $userWithToken = User::where('token_referido', $input['token_referido'])
            ->where('token_referido_expires_at', '>', now())
            ->first();

        if (!$userWithToken || $userWithToken->token_referido_used) {
            throw ValidationException::withMessages([
                'token_referido' => ['The provided token is invalid, expired, or hasbeen used.'],
            ]);
        } */
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        /*   // Mark the token as used
        $userWithToken->token_referido_used = true;
        $userWithToken->save();

        // Create the referido record
        Referido::create([
            'user_id' => $user->id,
            'revendedor_id' => $userWithToken->id,
        ]); */

        return $user;
    }
}
