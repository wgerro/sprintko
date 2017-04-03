<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        /* 
        * CATEGORY
        */

        DB::table('category')->insert([
            'name' => 'home',
            'description' => 'home is good !',
            'slug' => 'home'
        ]);
        /*
        * PAGES
        */

        DB::table('pages')->insert([
            'name' => 'Main page',
            'slug' => ' ',
            'title' => 'Main page',
            'description' => 'Description main page',
            'keyword' => 'sprint ko, content managemenet system',
            'robots' => 1,
            'active' => 1,
            'position' => 1,
            'category_id' => null,
            'is_widgets' => 1
        ]);

        /*
        * WIDGETS
        */

        DB::table('widgets')->insert([
            'name'=>'Latest posts',
            'active'=>1,
            'position'=>1,
            'file'=>'latest-post'
        ]);
        
        DB::table('widgets')->insert([
            'name'=>'Search',
            'active'=>1,
            'position'=>2,
            'file'=>'search'
        ]);

        DB::table('widgets')->insert([
            'name'=>'Social media',
            'active'=>1,
            'position'=>3,
            'file'=>'social-media'
        ]);

        DB::table('widgets')->insert([
            'name'=>'Category',
            'active'=>1,
            'position'=>4,
            'file'=>'list-category'
        ]);
        /* general template */
        DB::table('templates')->insert([
            'name' => 'CMS GERRO',
            'folder' => 'gerro'
        ]);
        /* glowna strona */
        DB::table('general')->insert([
            'articles_count' => 10,
            'api' => 'sprintko',
            'google_verification' => '',
            'logo' => 'storage/logo.png',
        ]);
        /* add communication cookies module */
        DB::table('pages-modules')->insert([
            'page_id' => 1,
            'module' => 1,
            'position' => 1
        ]);
        /* add form contact module */
        DB::table('pages-modules')->insert([
            'page_id' => 1,
            'module' => 5,
            'position' => 3
        ]);
        /* add post */
        $description = 'post-text-'.time().'.txt';
        Storage::put('posts/'.$description, 'Hello world');
        DB::table('posts')->insert([
            'user_id' => 1,
            'image' => 'none.png',
            'subject' => 'Hello world',
            'slug' => 'hello-world',
            'description' => $description,
            'position'=>1,
            'active'=>1,
            'created_at'=>date('Y-m-d H:i:s'),
        ]);
        DB::table('post-category')->insert([
            'post_id' => 1,
            'category_id' => 1,
        ]);


        DB::table('contents')->insert([
            'name' => 'content-1'
        ]);

        DB::table('page_contents')->insert([
            'file' => 'content-1.txt',
            'content_id' => 1,
            'page_id' => 1,
            'page_str' => '',
        ]);

        Storage::disk('local')->put('pages/content-1.txt', '<h1>Hello World - CONTENT</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>');

        Storage::put('modules/cookies/cookies.txt',"To make this site work properly, we sometimes place small data files called cookies on your device. Most big websites do this too.

<h4><b>What are cookies?</b></h4>
A cookie is a small text file that a website saves on your computer or mobile device when you visit the site. It enables the website to remember your actions and preferences (such as login, language, font size and other display preferences) over a period of time, so you don’t have to keep re-entering them whenever you come back to the site or browse from one page to another.

<h4><b>How do we use cookies?</b></h4>
Adjust this part of the page according to your needs. Explain which cookies you usein plain, jargon-free language. In particular:
<ul>
    <li>their purpose and the reason why they are being used, (e.g. to remember users' actions, to identify the user, for online behavioural advertising)</li>
    <li>if they are essential for the website or a given functionality to work or if they aim to enhance the performance of the website</li>
    <li>the types of cookies used (e.g. session or permanent, first or third-party)</li>
    <li>who controls/accesses the cookie-related information (website or third party)</li>
    <li>that the cookie will not be used for any purpose other than the one stated</li>
    <li>how consent can be withdrawn.</li>
</ul>
<h4><b>Example:</b></h4>
A number of our pages use cookies to remember:
your display preferences, such as contrast colour settings or font size
if you have already replied to a survey pop-up that asks you if the content was helpful or not (so you won't be asked again)
if you have agreed (or not) to our use of cookies on this site
Also, some videos embedded in our pages use a cookie to anonymously gather statistics on how you got there and what videos you visited.
Enabling these cookies is not strictly necessary for the website to work but it will provide you with a better browsing experience. You can delete or block these cookies, but if you do that some features of this site may not work as intended.
The cookie-related information is not used to identify you personally and the pattern data is fully under our control. These cookies are not used for any purpose other than those described here.
<h4><b>How to control cookies</b></h4>
You can control and/or delete cookies as you wish – for details, see aboutcookies.org. You can delete all cookies that are already on your computer and you can set most browsers to prevent them from being placed. If you do this, however, you may have to manually adjust some preferences every time you visit a site and some services and functionalities may not work.");
    }
}
