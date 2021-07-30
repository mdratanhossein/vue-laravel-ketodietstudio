<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AffiliateCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return $this->collection->toArray();
        return $this->collection->map(function ($referral) {
            return [
                'name'    => $referral->name,
                'contact' => $referral->affiliateInvite ? $referral->affiliateInvite->recipient : null
            ];
        })->toArray();
    }
}
