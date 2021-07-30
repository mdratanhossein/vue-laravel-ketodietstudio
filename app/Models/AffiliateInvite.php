<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateInvite extends Model
{
    protected $fillable = ['type', 'recipient', 'text', 'hash'];
}
