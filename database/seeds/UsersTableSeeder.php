<?php


use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::create([
            'email'               => 'janis@netcore.lv',
            'password'            => bcrypt('parole')
        ]);

        $user->joinAsAffiliate();

        $defaultLink = $user->affiliateLinks()->default()->first();

        $invite = $user->affiliateInvites()->create([
            'type'      => 'sms',
            'recipient' => '+37125502235',
            'text'      => 'Hey, join the affs!',
            'hash'      => 'abc'
        ]);


        /*
         * Add other user as referral
         * */
        $referral1 = \App\User::create([
            'name'                => 'Anna(w/Invite)',
            'email'               => 'referral1@netcore.lv',
            'password'            => bcrypt('parole')
        ]);
        $referral1->affiliate_invite_id = $invite->id;
        $referral1->save();

        $user->addReferral($referral1);

        $referral1->joinAsAffiliate();


        /*
         * Another one
         * */
        $referral2 = \App\User::create([
            'name'                => 'Roberts(w/Link)',
            'email'               => 'referral2@netcore.lv',
            'password'            => bcrypt('parole')
        ]);
        $referral2->affiliate_link_id = $defaultLink->id;
        $referral2->save();

        $user->addReferral($referral2);

        $referral2->joinAsAffiliate();


        /*
         * Another one
         * */
        $referral3 = \App\User::create([
            'name'                => 'Klinta(w/Link)',
            'email'               => 'referral2@netcore.lv',
        ]);
        $referral3->affiliate_link_id = $defaultLink->id;
        $referral3->save();

        $user->addReferral($referral3);



    }
}
