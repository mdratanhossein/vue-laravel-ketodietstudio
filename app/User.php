<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Hashids\Hashids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class User extends Authenticatable implements JWTSubject
{
    protected $fillable = ['key', 'email', 'payment_id', 'membership_id', 'stared_at',
                           'gender', 'familiar', 'preparation', 'physical_active', 'willing_option',
                           'age', 'unit', 'height_cm', 'height_ft', 'height_in', 'weight_kg', 'weight_lb',
                           'target_kg', 'target_lb', 'bmi', 'calorie', 'affiliate_joined_at', 'affiliate_by_user', 'affiliate_link_id'];

    protected $hidden = ['role', 'password', 'affiliate_by_user', 'is_admin', 'remember_token', 'payment_id',
                         'membership_id', 'affiliate_link_id', 'affiliate_invite_id'];

    /**
     * @return BelongsTo
     */
    public function payment(): belongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    /**
     * @return HasOne
     */
    public function settings(): HasOne
    {
        return $this->hasOne(WorkoutSetting::class);
    }

    /**
     * @return HasMany
     */
    public function workoutHistories(): HasMany
    {
        return $this->hasMany(WorkoutHistory::class);
    }

    /**
     * @return BelongsTo
     */
    public function membership(): belongsTo
    {
        return $this->belongsTo(Membership::class);
    }

    /**
     * @return HasMany
     */
    public function progresses(): hasMany
    {
        return $this->hasMany(Progress::class)->orderBy('created_at', 'DESC');
    }

    /**
     * @return BelongsToMany
     */
    public function recipes(): belongsToMany
    {
        return $this->belongsToMany(Recipe::class, 'user_recipe')
            ->withPivot('cycle', 'mealtime');
    }

    /**
     * @return BelongsToMany
     */
    public function products(): belongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * @return HasOne
     */
    public function referrer(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Determines if user is joined affiliate program
     *
     * @return bool
     */
    public function isAffiliate()
    {
        return ($this->password AND $this->affiliate_joined_at);
    }

    /**
     * @return HasMany
     */
    public function affiliateLinks()
    {
        return $this->hasMany(Models\AffiliateLink::class);
    }

    /**
     * @return HasOne
     */
    public function affiliateWallet()
    {
        return $this->hasOne(Models\AffiliateWallet::class);
    }

    /**
     * @return HasMany
     */
    public function affiliateInvites()
    {
        return $this->hasMany(Models\AffiliateInvite::class);
    }

    /**
     * @return $this
     */
    public function joinAsAffiliate()
    {
        $this->update([
            'affiliate_joined_at' => Carbon::now()
        ]);

        $hashids = new Hashids();

        $this->affiliateLinks()->firstOrCreate([
            'url' => '/d/' . $hashids->encode($this->id)
        ], ['is_default' => true]);

        $this->affiliateWallet()->firstOrCreate(['payout_minimum' => 100]);

        return $this;
    }

    /**
     * @param $user
     * @return $this
     */
    public function addReferral($user)
    {
        $user->affiliate_by_user = $this->id;
        $user->save();

        return $this;
    }

    /**
     * @return HasMany
     */
    public function referrals()
    {
        return $this->hasMany(User::class, 'affiliate_by_user');
    }

    /**
     * @return BelongsTo
     */
    public function affiliateInvite()
    {
        return $this->belongsTo(Models\AffiliateInvite::class);
    }


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
