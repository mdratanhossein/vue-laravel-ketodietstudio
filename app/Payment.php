<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = ['payment_id', 'method', 'email', 'amount', 'currency', 'detail'];

    public function user(): hasOne
    {
        return $this->hasOne(User::class);
    }
}
