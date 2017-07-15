<?php

namespace App;

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
        return  $this->hasOne('App\User', 'id', 'user_id');
    }
}
