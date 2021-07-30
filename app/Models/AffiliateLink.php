<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateLink extends Model
{
    protected $fillable = ['url', 'is_default'];

    /**
     * Filters and return results by default link
     *
     * @param $query
     * @return mixed
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', 1);
    }
}
