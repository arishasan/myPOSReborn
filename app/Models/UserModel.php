<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserModel extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_supplier',
        'name',
        'email',
        'email_verified_at',
        'username',
        'password',
        'mobile_number',
        'otp',
        'remember_token',
        'last_login',
        'role',
    ];
}
