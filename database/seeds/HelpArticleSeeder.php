<?php

use Illuminate\Database\Seeder;
use App\HelpArticle;

class HelpArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = 5;
        factory(HelpArticle::class, $count)->create();
    }
}
