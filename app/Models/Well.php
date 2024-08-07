<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Well extends Model
{
    use HasFactory;

    protected $table = 'Well';

    protected $primaryKey = 'Id';

    public function ngdu()
    {
        return $this->belongsTo(Ngdu::class, 'Ngdu_Id');
    }

    public function plc()
    {
        return $this->belongsTo(Plc::class, 'Plc_Id');
    }

    public function hd()
    {
        return $this->belongsTo(Hd::class, 'Hd_Id');
    }

    public function state()
    {
        return $this->belongsTo(WellState::class, 'WellState_Id');
    }
}
