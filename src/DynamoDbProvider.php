<?php

/**
 * User: ryosuke27
 * Date: 17/07/22
 * Time: 11:31 AM
 */

namespace App\Providers;


use App\Models\User;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;

class DynamoDbProvider implements UserProvider
{
    public function retrieveById($identifier)
    {
        return  User::whereIn('id', [$identifier])->first();
    }


    public function retrieveByToken($identifier, $token)
    {
        return User::whereIn('id', [$identifier])
            ->where('rememberToken', [$token])
            ->first();
    }


    public function updateRememberToken(Authenticatable $user, $token)
    {
        $user->setRememberToken($token);
        $user->save();
    }


    public function retrieveByCredentials(array $credentials)
    {
        $email = $credentials['email'];
        $user = User::where('email', $email)->first();
        return $user;
    }


    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        $password = $credentials['password'];
        return Hash::check($password, $user->password);
    }
}
