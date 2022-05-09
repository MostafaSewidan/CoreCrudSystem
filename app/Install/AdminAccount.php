<?php

namespace App\Install;

use Illuminate\Support\Facades\Hash;
use Modules\User\Entities\User;

class AdminAccount
{
    public function setup($data)
    {
        User::create([
            'name'          => $data['admin']['name'],
            'mobile'        => $data['admin']['mobile'],
            'email'         => $data['admin']['email'],
            'image'         => '/uploads/users/user.png',
            'password'      => Hash::make($data['admin']['password']),
        ]);
    }
}
