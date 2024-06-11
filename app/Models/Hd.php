<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hd extends Model
{
    use HasFactory;

    protected $table = 'Hd';

    protected $primaryKey = 'Id';

    public function wells()
    {
        return $this->hasMany(Well::class);
    }
}
