<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefClaim extends Model
{
    protected $table = 'RefClaim';

    protected $primaryKey = 'Id';

    public $timestamps = [];

    public function well()
    {
        return $this->belongsTo(Well::class, 'Well_Id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'User_Id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'Category_Id');
    }

    public function status()
    {
        return $this->belongsTo(RefClaimStatus::class, 'RefClaimStatus_Id');
    }

    public function claimsExecuting()
    {
        return $this->hasMany(RefClaimExecuting::class);
    }

    public function isOnConsideration(): bool
    {
        return optional($this->status)->RCStatusName === 'На рассмотрении';
    }
}
