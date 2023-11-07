<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ngdu extends Model
{
    use HasFactory;

    protected $table = 'Ngdu';

    protected $primaryKey = 'Id';

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function shops()
    {
        return $this->hasMany(Shop::class, 'Ngdu_Id');
    }
}
