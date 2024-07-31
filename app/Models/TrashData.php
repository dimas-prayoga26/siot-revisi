<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrashData extends Model
{
    use HasFactory, Uuid;

    public $incrementing = false;

    // In Laravel 6.0+ make sure to also set $keyType
    protected $keyType = 'string';

    protected $guarded = [];
    protected $table = 'trash_datas';

    public function owner(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function trashBin()
    {
        return $this->belongsTo(TrashBin::class, 'trash_bin_id', 'id');
    }

    // Relasi dengan model TrashBinCounter
    public function trashBinCounter()
    {
        return $this->belongsTo(TrashBinCounter::class, 'trash_bin_counter_id', 'id');
    }

    public function trashType()
    {
        return $this->belongsTo(TrashType::class, 'trash_type_id', 'id');
    }

    public function trashTypeDetail()
    {
        return $this->belongsTo(TrashTypeDetail::class, 'trash_type_detail_id', 'id');
    }
}
