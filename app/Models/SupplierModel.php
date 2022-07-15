<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SupplierModel extends Model
{
    use HasFactory;
    protected $table = 'supplier';
    protected $primaryKey = 'id';

    protected $fillable = ['nama', 'alamat', 'telepon', 'mobile_phone', 'email', 'pic', 'catatan', 'created_by', 'updated_by'];
}
