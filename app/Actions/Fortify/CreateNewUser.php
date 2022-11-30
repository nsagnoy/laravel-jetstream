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

        $messages = [
            'country.in' => "Must input a valid country. First letter should be capital."
        ];
        Validator::make($input, [
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'address' => 'required|regex:/(^[-0-9A-Za-z.,\/ ]+$)/',
            'city' => 'required',
            'country' => 'required',
            'zip' => 'required|regex:/\b\d{4}\b/',
            'birth_date' => 'required',
            'phone_no' => 'required|min:8|max:11',
            'role' => 'required',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ], $messages)->validate();

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
