<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {

        Validator::make($input, [
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'address' => 'required|string|regex:/(^[-0-9A-Za-z.,\/ ]+$)/',
            'city' => 'required|string|regex:/(^[-0-9A-Za-z.,\/ ]+$)/',
            'country' => 'required|string',
            'zip' => 'required|numeric|regex:/\b\d{4}\b/',
            'birth_date' => 'required|date',
            'phone_no' => 'required|string|min:8|max:11',
            'role' => 'required|string',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'address' => $input['address'],
            'city' => $input['city'],
            'country' => $input['country'],
            'zip' => $input['zip'],
            'birth_date' => $input['birth_date'],
            'phone_no' => $input['phone_no'],
            'role' => $input['role'],
        ]);
    }
}

