<?php

namespace App\Http\Controllers;

use App\User;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class RefferalController extends Controller
{
    /**
     * @param $hash
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function index($hash)
    {
        $hashids = new Hashids();
        $user_id = $hashids->decode($hash);

        if (!is_array($user_id)) {
            return redirect('/');
        }

        $referrer = User::find($user_id[0]);

        if (!$referrer) {
            return redirect('/');
        }

        if (!Cookie::has('referrer_id')) {
            Cookie::queue('referrer_id', $referrer->id, 86400 ); //60 days
        }

        return redirect('/');
    }
}
