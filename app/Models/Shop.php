<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $table = 'Shop';

    protected $primaryKey = 'Id';

    public function ngdu()
    {
        return $this->belongsTo(Ngdu::class);
    }
}
