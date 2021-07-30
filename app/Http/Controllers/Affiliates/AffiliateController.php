<?php

namespace App\Http\Controllers\Affiliates;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\AffiliateCollection;


class AffiliateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        if (!$user->isAffiliate()) {
            return response()->json(['error' => 'Expectation Failed'], 417);
        }

        $response = [];

        $response['default_link'] = url($user->affiliateLinks()->default()->first()->url);

        if( false ){
            $response['join_bonus'] = true;
        }

        $wallet = $user->affiliateWallet()
            ->select(['sales', 'money_withdrawn', 'money_earned','money_current'])
            ->first();


        $referrals = $user->referrals()->with('affiliateInvite')->whereNotNull('affiliate_joined_at')->orderBy('affiliate_joined_at', 'desc')->get();

        $referrals = new AffiliateCollection($referrals);

        $response['wallet']  = $wallet;
        $response['network'] = $referrals;
        $response['earnings'] = [];
        $response['links'] = $user->affiliateLinks()->get();

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        if ($user->isAffiliate()) {
            return response()->json(['message' => 'Already affiliate']);
        }

        $user->joinAsAffiliate();

        return response()->json(['message' => 'Success']);
    }
}
