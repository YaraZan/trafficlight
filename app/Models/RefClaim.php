<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefClaim extends Model
{
    use HasFactory;

    protected $table = 'RefClaim';

    public $timestamps = [];

    protected $primaryKey = 'Id';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
