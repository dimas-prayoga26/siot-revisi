<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dueses extends Model
{
    use HasFactory, Uuid;

    public $incrementing = false;

    // In Laravel 6.0+ make sure to also set $keyType
    protected $keyType = 'string';

    protected $guarded = [];
    protected $table = 'dueses';

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function metaDuesNominal()
    {
        return $this->belongsTo(MetaDuesNominals::class);
    }
}
