<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $fillable = ['price', 'currency', 'duration'];
}
