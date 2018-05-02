<?php

namespace App\Pagination;

use Illuminate\Support\HtmlString;
use Illuminate\Pagination\UrlWindow;
use Illuminate\Pagination\UrlWindowPresenterTrait;
use Illuminate\Contracts\Pagination\Paginator as PaginatorContract;
use Illuminate\Contracts\Pagination\Presenter as PresenterContract;
use Illuminate\Pagination\BootstrapThreeNextPreviousButtonRendererTrait;

class CustomPresenter implements PresenterContract
{
	use BootstrapThreeNextPreviousButtonRendererTrait, UrlWindowPresenterTrait;

	protected $paginator;

	protected $window;

	/* UrlWindow::make($paginator, PHP_INT_MAX) - da se vide svi brojevi strana, default bez drugog parametra */
	public function __construct(PaginatorContract $paginator, UrlWindow $window = null)
    {
        $this->paginator = $paginator;
        $this->window = is_null($window) ? UrlWindow::make($paginator,4) : $window->get();
    }

    public function render(){

    	if ($this->hasPages()) {
            return new HtmlString(sprintf(
                '<ul class="pagination">%s %s %s</ul>',
                $this->getPreviousButton('<i class="fa fa-btn fa-chevron-left" aria-hidden="true"></i>'),
                $this->getLinks(),
                $this->getNextButton('<i class="fa fa-btn fa-chevron-right" aria-hidden="true"></i>')
            ));
        }

        return '';
    }


    public function hasPages()
    {
        return $this->paginator->hasPages();
    }

    protected function getDisabledTextWrapper($text)
    {
        return '<li class="disabled"><span>'.$text.'</span></li>';
    }

    protected function getActivePageWrapper($text)
    {
        return '<li class="active"><span>'.$text.'</span></li>';
    }

    protected function getAvailablePageWrapper($url, $page, $rel = null)
    {
        $rel = is_null($rel) ? '' : ' rel="'.$rel.'"';

        return '<li><a href="'.htmlentities($url).'"'.$rel.'>'.$page.'</a></li>';
    }

    protected function getDots()
    {
        return $this->getDisabledTextWrapper('...');
    }

}