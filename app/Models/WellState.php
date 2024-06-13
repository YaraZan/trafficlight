<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WellState extends Model
{
    use HasFactory;

    protected $table = 'WellState';

    protected $primaryKey = 'Id';

    public function wells()
    {
        return $this->hasMany(WellAlarm::class);
    }
}
