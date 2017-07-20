<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $table = 'urls';
    protected $fillable = [
        'long_url',
        'short_url',
        'user_id'
    ];

    public function user() {
        return  $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
