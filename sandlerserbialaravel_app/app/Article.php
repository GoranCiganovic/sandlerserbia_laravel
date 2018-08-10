<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'html',
    ];

    /**
     * The attribute timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Returns Articles
     *
     * @return  \App\Article
     */
    public function get_articles()
    {
        return Article::all();
    }

    /**
     * Returns  Title
     *
     * @return  \App\Article
     */
    public function get_title()
    {
        return Article::where('id', 1)->first();
    }

    /**
     * Returns  Title Html
     *
     * @return  \App\Article
     */
    public function get_title_html()
    {
        return Article::where('id', 1)->first()->html;
    }

    /**
     * Returns  Header
     *
     * @return  \App\Article
     */
    public function get_header()
    {
        return Article::where('id', 2)->first();
    }

    /**
     * Returns  Header Html
     *
     * @return  \App\Article
     */
    public function get_header_html()
    {
        return Article::where('id', 2)->first()->html;
    }

    /**
     * Returns  Articles On Top
     *
     * @return  \App\Article
     */
    public function get_top_articles()
    {
        return Article::where('id', 3)->first();
    }

    /**
     * Returns  Articles On Top Html
     *
     * @return  \App\Article
     */
    public function get_top_articles_html()
    {
        return Article::where('id', 3)->first()->html;
    }

    /**
     * Returns  Event Place
     *
     * @return  \App\Article
     */
    public function get_event_place()
    {
        return Article::where('id', 4)->first();
    }

    /**
     * Returns  Event Place Html
     *
     * @return  \App\Article
     */
    public function get_event_place_html()
    {
        return Article::where('id', 4)->first()->html;
    }

    /**
     * Returns  Classes Number
     *
     * @return  \App\Article
     */
    public function get_classes_number()
    {
        return Article::where('id', 5)->first();
    }
 
    /**
     * Returns Classes Number Html
     *
     * @return  \App\Article
     */
    public function get_classes_number_html()
    {
        return Article::where('id', 5)->first()->html;
    }

    /**
     * Returns  Start And End
     *
     * @return  \App\Article
     */
    public function get_start_end()
    {
        return Article::where('id', 6)->first();
    }

    /**
     * Returns  Start And End Html
     *
     * @return  \App\Article
     */
    public function get_start_end_html()
    {
        return Article::where('id', 6)->first()->html;
    }

    /**
     * Returns  Work Dynamics
     *
     * @return  \App\Article
     */
    public function get_work_dynamics()
    {
        return Article::where('id', 7)->first();
    }

    /**
     * Returns  Work Dynamics Html
     *
     * @return  \App\Article
     */
    public function get_work_dynamics_html()
    {
        return Article::where('id', 7)->first()->html;
    }

    /**
     * Returns  Event Time
     *
     * @return  \App\Article
     */
    public function get_event_time()
    {
        return Article::where('id', 8)->first();
    }

    /**
     * Returns  Event Time Html
     *
     * @return  \App\Article
     */
    public function get_event_time_html()
    {
        return Article::where('id', 8)->first()->html;
    }

    /**
     * Returns  Participants Number
     *
     * @return  \App\Article
     */
    public function get_participants_number()
    {
        return Article::where('id', 9)->first();
    }

    /**
     * Returns  Participants Number Html
     *
     * @return  \App\Article
     */
    public function get_participants_number_html()
    {
        return Article::where('id', 9)->first()->html;
    }

    /**
     * Returns  Agreement
     *
     * @return  \App\Article
     */
    public function get_agreement()
    {
        return Article::where('id', 10)->first();
    }

    /**
     * Returns  Agreement Html
     *
     * @return  \App\Article
     */
    public function get_agreement_html()
    {
        return Article::where('id', 10)->first()->html;
    }

    /**
     * Returns  Articles In The Middle
     *
     * @return  \App\Article
     */
    public function get_middle_articles()
    {
        return Article::where('id', 11)->first();
    }

    /**
     * Returns  Articles In The Middle Html
     *
     * @return  \App\Article
     */
    public function get_middle_articles_html()
    {
        return Article::where('id', 11)->first()->html;
    }

    /**
     * Returns  Payings
     *
     * @return  \App\Article
     */
    public function get_payings()
    {
        return Article::where('id', 12)->first();
    }

    /**
     * Returns  Payings Html
     *
     * @return  \App\Article
     */
    public function get_payings_html()
    {
        return Article::where('id', 12)->first()->html;
    }

    /**
     * Returns  Articles On The Botton
     *
     * @return  \App\Article
     */
    public function get_bottom_articles()
    {
        return Article::where('id', 13)->first();
    }

    /**
     * Returns  Articles On The Botton Html
     *
     * @return  \App\Article
     */
    public function get_bottom_articles_html()
    {
        return Article::where('id', 13)->first()->html;
    }

    /**
     * Returns  Signature
     *
     * @return  \App\Article
     */
    public function get_signature()
    {
        return Article::where('id', 14)->first();
    }

    /**
     * Returns  Signature Html
     *
     * @return  \App\Article
     */
    public function get_signature_html()
    {
        return Article::where('id', 14)->first()->html;
    }

    /**
     * Returns  Attachment
     *
     * @return  \App\Article
     */
    public function get_attachment()
    {
        return Article::where('id', 15)->first();
    }

    /**
     * Returns  Attachment Html
     *
     * @return  \App\Article
     */
    public function get_attachment_html()
    {
        return Article::where('id', 15)->first()->html;
    }

    /**
     * Returns Articles Html Array For PDF View
     *
     * @return array
     */
    public function get_articles_html()
    {
        $article['title'] = $this->get_title_html();
        $article['top_articles'] = $this->get_top_articles_html();
        $article['event_place'] = $this->get_event_place_html();
        $article['classes_number'] = $this->get_classes_number_html();
        $article['start_end'] = $this->get_start_end_html();
        $article['work_dynamics'] = $this->get_work_dynamics_html();
        $article['event_time'] = $this->get_event_time_html();
        $article['participants_number'] = $this->get_participants_number_html();
        $article['agreement'] = $this->get_agreement_html();
        $article['middle_articles'] = $this->get_middle_articles_html();
        $article['payings'] = $this->get_payings_html();
        $article['bottom_articles'] = $this->get_bottom_articles_html();
        return $article;
    }
}
