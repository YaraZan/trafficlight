<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plc extends Model
{
    use HasFactory;

    protected $table = 'Plc';

    protected $primaryKey = 'Id';

    public function wells()
    {
        return $this->hasMany(Well::class);
    }
}
