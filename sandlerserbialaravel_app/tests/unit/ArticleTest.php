<?php

use App\Article;

class ArticleTest extends TestCase
{
    /**
     * Article object
     *
     * @var App\Article
     */
    protected static $article;

    /**
     * Set Article
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        self::$article = Article::first();
    }

     /**
     * Test If Article Object Is An Instance of Article Class
     *
     * @test
     * @return void
     */
    public function if_is_instance_of_article()
    {
        $this->assertInstanceOf('App\Article', self::$article);
    }

    /**
     * Test if Articles Table Returns 15 Record
     *
     * @test
     * @return void
     */
    public function if_articles_table_returns_15_records()
    {
        $this->assertEquals(15, Article::all()->count());
    }

    /**
     * Test if Method get_articles Returns All Articles
     *
     * @test
     * @return void
     */
    public function get_articles_returns_all_articles()
    {
        $this->assertEquals((new Article)->get_articles(), Article::all());
    }

    /**
     * Test if Method get_title Returns Article Id 1
     *
     * @test
     * @return void
     */
    public function get_title_returns_article_id_1()
    {
        $this->assertEquals((new Article)->get_title(), Article::where('id', 1)->first());
    }

    /**
     * Test if Method get_title_html Returns Article Id 1 Html
     *
     * @test
     * @return void
     */
    public function get_title_html_returns_article_id_1_html()
    {
        $this->assertEquals((new Article)->get_title_html(), Article::where('id', 1)->first()->html);
    }

    /**
     * Test if Method get_header Returns Article Id 2
     *
     * @test
     * @return void
     */
    public function get_header_returns_article_id_2()
    {
        $this->assertEquals((new Article)->get_header(), Article::where('id', 2)->first());
    }

    /**
     * Test if Method get_header_html Returns Article Id 2 Html
     *
     * @test
     * @return void
     */
    public function get_header_html_returns_article_id_2_html()
    {
        $this->assertEquals((new Article)->get_header_html(), Article::where('id', 2)->first()->html);
    }

     /**
     * Test if Method get_top_articles Returns Article Id 3
     *
     * @test
     * @return void
     */
    public function get_top_articles_returns_article_id_3()
    {
        $this->assertEquals((new Article)->get_top_articles(), Article::where('id', 3)->first());
    }

    /**
     * Test if Method get_top_articles_html Returns Article Id 3 Html
     *
     * @test
     * @return void
     */
    public function get_top_articles_html_returns_article_id_3_html()
    {
        $this->assertEquals((new Article)->get_top_articles_html(), Article::where('id', 3)->first()->html);
    }

     /**
     * Test if Method get_event_place Returns Article Id 4
     *
     * @test
     * @return void
     */
    public function get_event_place_returns_article_id_4()
    {
        $this->assertEquals((new Article)->get_event_place(), Article::where('id', 4)->first());
    }

    /**
     * Test if Method get_event_place_html Returns Article Id 4 Html
     *
     * @test
     * @return void
     */
    public function get_event_place_html_returns_article_id_4_html()
    {
        $this->assertEquals((new Article)->get_event_place_html(), Article::where('id', 4)->first()->html);
    }


     /**
     * Test if Method get_classes_number Returns Article Id 5
     *
     * @test
     * @return void
     */
    public function get_classes_number_returns_article_id_5()
    {
        $this->assertEquals((new Article)->get_classes_number(), Article::where('id', 5)->first());
    }

    /**
     * Test if Method get_classes_number_html Returns Article Id 5 Html
     *
     * @test
     * @return void
     */
    public function get_classes_number_html_returns_article_id_5_html()
    {
        $this->assertEquals((new Article)->get_classes_number_html(), Article::where('id', 5)->first()->html);
    }

     /**
     * Test if Method get_start_end Returns Article Id 6
     *
     * @test
     * @return void
     */
    public function get_start_end_returns_article_id_6()
    {
        $this->assertEquals((new Article)->get_start_end(), Article::where('id', 6)->first());
    }

    /**
     * Test if Method get_start_end_html Returns Article Id 6 Html
     *
     * @test
     * @return void
     */
    public function get_start_end_html_returns_article_id_6_html()
    {
        $this->assertEquals((new Article)->get_start_end_html(), Article::where('id', 6)->first()->html);
    }

     /**
     * Test if Method get_work_dynamics Returns Article Id 7
     *
     * @test
     * @return void
     */
    public function get_work_dynamics_returns_article_id_7()
    {
        $this->assertEquals((new Article)->get_work_dynamics(), Article::where('id', 7)->first());
    }

    /**
     * Test if Method get_work_dynamics_html Returns Article Id 7 Html
     *
     * @test
     * @return void
     */
    public function get_work_dynamics_html_returns_article_id_7_html()
    {
        $this->assertEquals((new Article)->get_work_dynamics_html(), Article::where('id', 7)->first()->html);
    }

     /**
     * Test if Method get_event_time Returns Article Id 8
     *
     * @test
     * @return void
     */
    public function get_event_time_returns_article_id_8()
    {
        $this->assertEquals((new Article)->get_event_time(), Article::where('id', 8)->first());
    }

    /**
     * Test if Method get_event_time_html Returns Article Id 8 Html
     *
     * @test
     * @return void
     */
    public function get_event_time_html_returns_article_id_8_html()
    {
        $this->assertEquals((new Article)->get_event_time_html(), Article::where('id', 8)->first()->html);
    }

     /**
     * Test if Method get_participants_number Returns Article Id 9
     *
     * @test
     * @return void
     */
    public function get_participants_number_returns_article_id_9()
    {
        $this->assertEquals((new Article)->get_participants_number(), Article::where('id', 9)->first());
    }

    /**
     * Test if Method get_participants_number_html Returns Article Id 9 Html
     *
     * @test
     * @return void
     */
    public function get_participants_number_html_returns_article_id_9_html()
    {
        $this->assertEquals((new Article)->get_participants_number_html(), Article::where('id', 9)->first()->html);
    }

     /**
     * Test if Method get_agreement Returns Article Id 10
     *
     * @test
     * @return void
     */
    public function get_agreement_returns_article_id_10()
    {
        $this->assertEquals((new Article)->get_agreement(), Article::where('id', 10)->first());
    }

    /**
     * Test if Method get_agreement_html Returns Article Id 10 Html
     *
     * @test
     * @return void
     */
    public function get_agreement_html_returns_article_id_10_html()
    {
        $this->assertEquals((new Article)->get_agreement_html(), Article::where('id', 10)->first()->html);
    }

     /**
     * Test if Method get_middle_articles Returns Article Id 11
     *
     * @test
     * @return void
     */
    public function get_middle_articles_returns_article_id_11()
    {
        $this->assertEquals((new Article)->get_middle_articles(), Article::where('id', 11)->first());
    }

    /**
     * Test if Method get_middle_articles_html Returns Article Id 11 Html
     *
     * @test
     * @return void
     */
    public function get_middle_articles_html_returns_article_id_11_html()
    {
        $this->assertEquals((new Article)->get_middle_articles_html(), Article::where('id', 11)->first()->html);
    }

     /**
     * Test if Method get_payings Returns Article Id 12
     *
     * @test
     * @return void
     */
    public function get_payings_returns_article_id_12()
    {
        $this->assertEquals((new Article)->get_payings(), Article::where('id', 12)->first());
    }

    /**
     * Test if Method get_payings_html Returns Article Id 12 Html
     *
     * @test
     * @return void
     */
    public function get_payings_html_returns_article_id_12_html()
    {
        $this->assertEquals((new Article)->get_payings_html(), Article::where('id', 12)->first()->html);
    }

    /**
     * Test if Method get_bottom_articles Returns Article Id 13
     *
     * @test
     * @return void
     */
    public function get_bottom_articles_returns_article_id_13()
    {
        $this->assertEquals((new Article)->get_bottom_articles(), Article::where('id', 13)->first());
    }

    /**
     * Test if Method get_bottom_articles_html Returns Article Id 13 Html
     *
     * @test
     * @return void
     */
    public function get_bottom_articles_html_returns_article_id_13_html()
    {
        $this->assertEquals((new Article)->get_bottom_articles_html(), Article::where('id', 13)->first()->html);
    }

     /**
     * Test if Method get_signature Returns Article Id 14
     *
     * @test
     * @return void
     */
    public function get_signature_returns_article_id_14()
    {
        $this->assertEquals((new Article)->get_signature(), Article::where('id', 14)->first());
    }

    /**
     * Test if Method get_signature_html Returns Article Id 14 Html
     *
     * @test
     * @return void
     */
    public function get_signature_html_returns_article_id_14_html()
    {
        $this->assertEquals((new Article)->get_signature_html(), Article::where('id', 14)->first()->html);
    }

     /**
     * Test if Method get_attachment Returns Article Id 15
     *
     * @test
     * @return void
     */
    public function get_attachment_returns_article_id_15()
    {
        $this->assertEquals((new Article)->get_attachment(), Article::where('id', 15)->first());
    }

    /**
     * Test if Method get_attachment_html Returns Article Id 15 Html
     *
     * @test
     * @return void
     */
    public function get_attachment_html_returns_article_id_15_html()
    {
        $this->assertEquals((new Article)->get_attachment_html(), Article::where('id', 15)->first()->html);
    }

    /**
     * Test if Method get_articles_html Returns Array Of Article Model Methods
     *
     * @test
     * @return void
     */
    public function get_articles_html_returns_array_of_article_model_methods()
    {
        $this->assertEquals(
            (new Article)->get_articles_html(),
            [
                'title' => (new Article)->get_title_html(),
                'top_articles' => (new Article)->get_top_articles_html(),
                'event_place'=> (new Article)->get_event_place_html(),
                'classes_number'=> (new Article)->get_classes_number_html(),
                'start_end'=> (new Article)->get_start_end_html(),
                'work_dynamics'=> (new Article)->get_work_dynamics_html(),
                'event_time'=> (new Article)->get_event_time_html(),
                'participants_number'=> (new Article)->get_participants_number_html(),
                'agreement'=> (new Article)->get_agreement_html(),
                'middle_articles'=> (new Article)->get_middle_articles_html(),
                'payings'=> (new Article)->get_payings_html(),
                'bottom_articles'=> (new Article)->get_bottom_articles_html(),
             ]
        );
    }
}
