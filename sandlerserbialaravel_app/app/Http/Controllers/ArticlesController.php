<?php

namespace App\Http\Controllers;

use App\Article;
use App\Classes\Parse;
use App\Template;
use Exception;
use Illuminate\Http\Request;
use Session;

class ArticlesController extends Controller
{
 
    /**
     * Create a new Article Controller instance.
     *
     * @return void
     */
    public function __construct(Article $article = null, Template $template = null, Parse $parse = null)
    {
        $this->article = $article;
        $this->template = $template;
        $this->parse = $parse;
    }

    /**
     * Display Articles For Contract Template (PDF)
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* Template Options */
        $template_options = $this->template->get_template_options();
        /* Articles */
        $articles = $this->article->get_articles();

        return view('articles.articles', compact('template_options', 'articles'));
    }

    /**
     * Show the form for editing Article
     *
     * @param  \App\Article $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        /* Allowed Articles For Update */
        if ($this->can_article_change($article)) {
            return view('articles.edit_article', compact('article'));
        } else {
            return back();
        }
    }

    /**
     * Update Article
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        try {
            /* Allowed Articles For Update */
            if ($this->can_article_change($article)) {
                /* Article Title */
                $name = $request->input('title');
                /* Article Content With Html Tags */
                $html = $this->parse->remove_unnecessary_html_tags($request->input('article'));
                /* Remove Html Tags And Html Space Entities  From Article Content */
                $text = $this->parse->remove_html_space_entity(strip_tags($html));

                $request['article'] = $text;
                
                $this->validate($request, [
                    'title' => "required|max:100|unique:articles,name,{$article->id}",
                    'article' => 'filled|max:10000',
                ]);

                /* Update Article */
                $a = $article->update(['name' => $name, 'html' => $html]);


                $request->session()->flash('message', 'Podaci su uspešno izmenjeni.');
            }
        } catch (Exception $e) {
            $request->session()->flash('message', 'Greška! Podaci nisu izmenjeni.');
        }
        return back();
    }

    /**
     * Can Article Change (Articles Allowed To Change)
     *
     * @param  \App\Article  $article
     * @return bool
     */
    public function can_article_change(Article $article)
    {
        $articles_can_change = [1, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13];
        if (in_array($article->id, $articles_can_change)) {
            return true;
        } else {
            return false;
        }
    }
}
