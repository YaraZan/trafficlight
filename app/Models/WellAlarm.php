<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WellAlarm extends Model
{
    use HasFactory;

    protected $table = 'WellAlarm';

    protected $primaryKey = 'Id';

    public function well()
    {
        return $this->belongsTo(Well::class, 'Well_Id');
    }

    public function ngdu()
    {
        return $this->belongsTo(Ngdu::class, 'Ngdu_Id');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'Shop_Id');
    }

    public function state()
    {
        return $this->belongsTo(WellState::class, 'WellState_Id');
    }
}
