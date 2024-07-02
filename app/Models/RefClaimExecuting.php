<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefClaimExecuting extends Model
{
    use HasFactory;

    protected $table = 'ref_claim_executing';

    protected $primaryKey = 'id';

    public $timestamps = [];

    public function claim()
    {
        return $this->belongsTo(RefClaim::class, 'ref_claim_id');
    }

    public function status()
    {
        return $this->belongsTo(RefClaimStatus::class, 'rcs_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'User_Id');
    }
}
