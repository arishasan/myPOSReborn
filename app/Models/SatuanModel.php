<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SatuanModel extends Model
{
    use HasFactory;
    protected $table = 'satuan';
    protected $primaryKey = 'id';

    protected $fillable = ['nama', 'status', 'created_by'];
}
