<?php
/**
 * Created by PhpStorm.
 * User: qzhang
 * Date: 2016/6/12
 * Time: 17:15
 */

namespace Xiaoshu\Foundation\Presenters;


use Illuminate\Contracts\Pagination\Presenter;
use Illuminate\Support\HtmlString;
use Illuminate\Pagination\UrlWindow;
use Illuminate\Pagination\UrlWindowPresenterTrait;
use Illuminate\Pagination\BootstrapThreeNextPreviousButtonRendererTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PagingPresenter implements Presenter
{
    protected $paginator;
    protected $window;

    use BootstrapThreeNextPreviousButtonRendererTrait, UrlWindowPresenterTrait;

    public function __construct(LengthAwarePaginator $paginator, UrlWindow $window = null)
    {
        $this->paginator = $paginator;
        $this->window = is_null($window) ? UrlWindow::make($paginator) : $window->get();
    }

    public function hasPages()
    {
        return $this->paginator->hasPages();
    }

    protected function getDisabledTextWrapper($text)
    {
        return "<span class='pre_page'>$text</span>&nbsp;";
    }

    public function getPreviousButton($text = '&laquo;')
    {
        if ($this->paginator->currentPage() <= 1) {
            return $this->getDisabledTextWrapper($text);
        }

        $url = $this->paginator->url(
            $this->paginator->currentPage() - 1
        );

        return "<a href='$url' class='pre_page' >$text</a>";
    }

    public function getNextButton($text = '&raquo;')
    {
        if (! $this->paginator->hasMorePages()) {
            return $this->getDisabledTextWrapper($text);
        }

        $url = $this->paginator->url(
            $this->paginator->currentPage() + 1
        );

        return "<a href='$url' class='next_page' >$text</a>";
    }

    protected function getAvailablePageWrapper($url, $page)
    {
        return "<a href='$url' class='number' >$page</a>";
    }

    protected function getActivePageWrapper($text)
    {
        return "<span class='current'>$text</span>";
    }

    public function render()
    {
        if ($this->hasPages()) {
            return new HtmlString(sprintf(
                '%s %s %s',
                $this->getPreviousButton('上一页'),//具体实现可以查看该方法
                $this->getLinks(),
                $this->getNextButton('下一页')//具体实现可以查看该方法
            ));
        }

        return '';
    }

    protected function getDots()
    {
        return $this->getDisabledTextWrapper('...');
    }
}
