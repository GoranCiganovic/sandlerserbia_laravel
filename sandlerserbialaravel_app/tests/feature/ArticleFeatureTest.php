<?php

use App\Article;
use App\Template;

class ArticleFeatureTest extends TestCase
{
     /**
     * Article
     *
     * @var App\Article
     */
    protected static $article;

     /**
     * All Articles - Collection
     *
     * @var App\Article
     */
    protected static $all_articles;

    /**
     * Sets Article And  Articles Collection
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        if (is_null(self::$article)) {
            self::$article = Article::first();
        }

        if (is_null(self::$all_articles)) {
            self::$all_articles = Article::all();
        }
    }

    /**
     * Test Admin Can See All Articles (ArticlesController@index)
     *
     * @test
     * @return void
    */
    public function admin_can_see_all_articles()
    {
        $this->actingAs(self::$admin)
            ->visit('/home')
            ->click('#articles_edit')
            ->seePageIs('/articles')
            ->see('Šablon Ugovora')
            ->see('Opcije');
        foreach (self::$all_articles as $article) {
            $this->see($article->name);
        }
    }

    /**
     * Test Http Get Request Showing All Articles As Admin (ArticlesController@index)
     *
     * @test
     * @return void
     */
    public function http_get_request_show_all_articles_as_admin()
    {
        $this->actingAs(self::$admin)
            ->get('/articles')
            ->assertResponseStatus(200)
            ->assertViewHas(['template_options', 'articles']);
    }

    /**
     * Test User Can See All Articles For Contract Template (ArticlesController@index)
     *
     * @test
     * @return void
    */
    public function user_can_see_all_articles()
    {
        $this->actingAs(self::$user)
            ->visit('/home')
            ->click('#articles_edit')
            ->seePageIs('/articles')
            ->see('Šablon Ugovora')
            ->see('Opcije');
        foreach (self::$all_articles as $article) {
            $this->see($article->name);
        }
    }

    /**
     * Test Http Get Request Showing All Articles As User (ArticlesController@index)
     *
     * @test
     * @return void
     */
    public function http_get_request_show_all_articles_as_user()
    {
        $this->actingAs(self::$user)
            ->get('/articles')
            ->assertResponseStatus(200)
            ->assertViewHas(['template_options', 'articles']);
    }

    /**
     * Test Admin Can Return From All Articles Page To Home Page (ArticlesController@index)
     *
     * @test
     * @return void
    */
    public function admin_can_return_from_all_articles_page_to_home_page()
    {
        $this->actingAs(self::$admin)
            ->visit('/home')
            ->visit('/articles')
            ->see('Šablon Ugovora')
            ->click('Nazad')
            ->seePageIs('/home')
            ->see('Sandler Srbija Baza');
    }

    /**
     * Test User Can Return From All Articles Page To Home Page (ArticlesController@index)
     *
     * @test
     * @return void
    */
    public function user_can_return_from_all_articles_page_to_home_page()
    {
        $this->actingAs(self::$user)
            ->visit('/home')
            ->visit('/articles')
            ->see('Šablon Ugovora')
            ->click('Nazad')
            ->seePageIs('/home')
            ->see('Sandler Srbija Baza');
    }
  
    /**
     * Test Admin Can See The Form For Editing Article (ArticlesController@edit)
     *
     * @test
     * @return void
     */
    public function admin_can_see_form_for_editing_article()
    {
        $this->actingAs(self::$admin)
            ->visit('/articles')
            ->click('#article'.self::$article->id)
            ->seePageIs('/article/edit/'.self::$article->id)
            ->see(self::$article->name)
            ->see('POTVRDI IZMENU');
    }

    /**
     * Test Http Get Request Showing Form For Editing Article As Admin (ArticlesController@edit)
     *
     * @test
     * @return void
     */
    public function http_get_request_edit_article_as_admin()
    {
        $this->actingAs(self::$admin)
            ->get('/article/edit/' . self::$article->id)
            ->assertResponseStatus(200)
            ->assertViewHas('article');
    }

    /**
     * Test User Can See The Form For Editing Article (ArticlesController@edit)
     *
     * @test
     * @return void
     */
    public function user_can_see_form_for_editing_article()
    {
        $this->actingAs(self::$user)
            ->visit('/articles')
            ->click('#article'.self::$article->id)
            ->seePageIs('/article/edit/'.self::$article->id)
            ->see(self::$article->name)
            ->see('POTVRDI IZMENU');
    }

    /**
     * Test Http Get Request Showing Form For Editing Article As User (ArticlesController@edit)
     *
     * @test
     * @return void
     */
    public function http_get_request_edit_article_as_user()
    {
        $this->actingAs(self::$user)
            ->get('/article/edit/' . self::$article->id)
            ->assertResponseStatus(200)
            ->assertViewHas('article');
    }

    /**
     * Test Admin Can Return From Edit Article Page To All Articles Page (ArticlesController@edit)
     *
     * @test
     * @return void
    */
    public function admin_can_return_from_edit_article_page_to_all_articles_page()
    {
        $this->actingAs(self::$admin)
            ->visit('/articles')
            ->visit('/article/edit/' . self::$article->id)
            ->see(self::$article->name)
            ->click('Template')
            ->seePageIs('/articles')
            ->see('Šablon Ugovora');
    }

    /**
     * Test User Can Return From Edit Article Page To All Articles Page (ArticlesController@edit)
     *
     * @test
     * @return void
    */
    public function user_can_return_from_edit_article_page_to_all_articles_page()
    {
        $this->actingAs(self::$user)
            ->visit('/articles')
            ->visit('/article/edit/' . self::$article->id)
            ->see(self::$article->name)
            ->click('Template')
            ->seePageIs('/articles')
            ->see('Šablon Ugovora');
    }

     /**
     * Test Admin Can Update Article (ArticlesController@update)
     *
     * @test
     * @return void
     */
    public function admin_can_update_article()
    {
        $this->actingAs(self::$admin)
            ->visit('/article/edit/' . self::$article->id)
            ->type($name = 'Article Name', 'title')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/article/edit/' . self::$article->id)
            ->seeInDatabase('articles', ['id' => self::$article->id, 'name' => $name])
            ->see('Podaci su uspešno izmenjeni.');
    }

    /**
     * Test User Can Not Update Article (ArticlesController@update)
     *
     * @test
     * @return void
     */
    public function user_can_not_update_article()
    {
        $this->actingAs(self::$user)
            ->visit('/article/edit/' . self::$article->id)
            ->type($name = 'ArticleName', 'title')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/article/edit/' . self::$article->id)
            ->dontSeeInDatabase('articles', ['id' => self::$article->id, 'name' => $name])
            ->see('Nemate ovlašćenje za ovu akciju!');
    }

    /**
     * Test Update Article Title Is Required (ArticlesController@update)
     *
     * @test
     * @return void
     */
    public function update_article_title_is_required()
    {
        $this->actingAs(self::$admin)
            ->visit('/article/edit/' . self::$article->id)
            ->type($title = '', 'title')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/article/edit/' . self::$article->id)
            ->dontSeeInDatabase('articles', ['id' => self::$article->id, 'name' => $title])
            ->see('Polje Naziv je obavezno.');
    }


    /**
     * Test Update Article Title Must Be Maximimum 100 Characters Long (ArticlesController@update)
     *
     * @test
     * @return void
     */
    public function update_article_title_must_be_maximum_100_characters_long()
    {
        $this->actingAs(self::$admin)
            ->visit('/article/edit/' . self::$article->id)
            ->type($title = str_random(101), 'title')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/article/edit/' . self::$article->id)
            ->dontSeeInDatabase('articles', ['id' => self::$article->id, 'name' => $title])
            ->see('Polje Naziv mora sadržati manje od 100 karaktera.');
    }

    /**
     * Test Update Article Title Must Be Unique (ArticlesController@update)
     *
     * @test
     * @return void
     */
    public function update_article_title_must_be_unique()
    {
        $title = Article::where('id', '!=', self::$article->id)->first()->name;
        $this->actingAs(self::$admin)
            ->visit('/article/edit/' . self::$article->id)
            ->type($title, 'title')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/article/edit/' . self::$article->id)
            ->dontSeeInDatabase('articles', ['id' => self::$article->id, 'name' => $title])
            ->see('Polje Naziv već postoji.');
    }

    /**
     * Test Update Article Article Must Be Filled (ArticlesController@update)
     *
     * @test
     * @return void
    */
    public function update_article_article_must_be_filled()
    {
        $this->actingAs(self::$admin)
            ->visit('/article/edit/' . self::$article->id)
            ->type($article = '', 'article')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/article/edit/' . self::$article->id)
            ->dontSeeInDatabase('articles', ['id' => self::$article->id, 'html' => $article])
            ->see('Polje Sadržaj mora biti popunjeno.');
    }

    /**
     * Test Update Article Article Must Be Maximimum 10000 Characters Long (ArticlesController@update)
     *
     * @test
     * @return void
     */
    public function update_article_article_must_be_maximum_10000_characters_long()
    {
        $this->actingAs(self::$admin)
            ->visit('/article/edit/' . self::$article->id)
            ->type($article = str_random(10001), 'article')
            ->press('POTVRDI IZMENU')
            ->seePageIs('/article/edit/' . self::$article->id)
            ->dontSeeInDatabase('articles', ['id' => self::$article->id, 'html' => $article])
            ->see('Polje Sadržaj mora sadržati manje od 10000 karaktera.');
    }

    /**
     * Test False Update Article With Get Method (ArticlesController@update)
     *
     * @test
     * @return void
     */
    public function false_update_article_with_get_method()
    {
        $this->actingAs(self::$user)
            ->get('article/update/' . self::$article->id)
            ->assertResponseStatus(405)
            ->see('405 Something Went Wrong');
    }

     /**
     * Test Articles Can Be Changed (ArticlesController@can_article_change)
     *
     * @test
     * @return void
     */
    public function articles_can_be_changed()
    {
        $articles_can_change = Article::whereIn('id', [1, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]);
        foreach ($articles_can_change as $article) {
            $this->assertInstanceOf('App\Article', $article);
            $this->assertTrue((new App\Http\Controllers\ArticlesController)->can_article_change(Article::where('id', $article->id)));
        }
    }

     /**
     * Test Articles Can Not Be Changed (ArticlesController@can_article_change)
     *
     * @test
     * @return void
     */
    public function articles_can_not_be_changed()
    {
        $articles_can_not_change = Article::whereIn('id', [2, 14, 15]);
        foreach ($articles_can_not_change as $article) {
            $this->assertInstanceOf('App\Article', $article);
            $this->assertFalse((new App\Http\Controllers\ArticlesController)->can_article_change(Article::where('id', $article->id)));
        }
    }
}
