<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService
{

    public function register(array $data)
    {
        try {
            DB::beginTransaction();

            $data['password'] = Hash::make($data['password']);
            $user = \App\Models\User::create($data);
            $user->addRole('admin');

            DB::commit();

            return ['message' => 'Użytkownik został utworzony'];


        } catch (\Exception $e) {
            DB::rollBack();
            return ['message' => 'Błąd podczas tworzenia użytkownika - spróbuj jeszcze raz'];
        }
    }
}
