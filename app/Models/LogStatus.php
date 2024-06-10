<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogStatus extends Model
{
    use HasFactory;

    protected $table = 'log_status';

    public $timestamps = [];

    public function logs() {
        return $this->hasMany(Log::class);
    }
}
