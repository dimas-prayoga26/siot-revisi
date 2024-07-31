<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory, Uuid;

    public $incrementing = false;

    // In Laravel 6.0+ make sure to also set $keyType
    protected $keyType = 'string';

    protected $guarded = [];

    public function date() {
        return $this->belongsTo(MetaDate::class, 'meta_date_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
