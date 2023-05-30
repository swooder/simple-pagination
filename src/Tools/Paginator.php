<?php

namespace Swooder\SimplePagination\Tools;

use Encore\Admin\Grid\Tools\Paginator as BasePaginator;
use Encore\Admin\Grid\Tools\PerPageSelector;
use Swooder\SimplePagination\Grid\SimpleGrid;
use function collect;
use function trans;

class Paginator extends BasePaginator
{
    /**
     * Initialize work for Paginator.
     *
     * @return void
     */
    protected function initPaginator()
    {
        $this->paginator = $this->grid->model()->eloquent();

        if ($this->paginator instanceof \Illuminate\Pagination\Paginator) {
            $this->paginator->appends(request()->all());
        }
    }
    /**
     * Get per-page selector.
     *
     * @return PerPageSelector
     */
    protected function perPageSelector()
    {
        if (!$this->perPageSelector) {
            return;
        }

        return new PerPageSelector($this->grid);
    }

    /**
     * Get range infomation of paginator.
     *
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    protected function paginationRanger()
    {
        $parameters = [
            'first' => $this->paginator->firstItem(),
            'last'  => $this->paginator->lastItem(),
            'total' => '9999...',
        ];

        $parameters = collect($parameters)->flatMap(function ($parameter, $key) {
            return [$key => "<b>$parameter</b>"];
        });

        return trans('admin.pagination.range', $parameters->all());
    }

    /**
     * Get Pagination links.
     *
     * @return string
     */
    protected function paginationLinks()
    {
        if ($this->grid instanceof SimpleGrid) {
            if (!$this->grid->isSimple()) {
                return $this->paginator->render('simplepagination::pagination', ['elements' => $this->elements()]);
            }
        }

        return $this->paginator->render('simplepagination::pagination');
    }

    /**
     * Get the array of elements to pass to the view.
     *
     * @return array
     */
    protected function elements()
    {
        $paginator = clone $this->paginator;

        $window = UrlWindow::make($paginator);

        return array_filter([
            $window['first'],
            is_array($window['slider']) ? '...' : null,
            $window['slider'],
            is_array($window['last']) ? '...' : null,
            $window['last'],
        ]);
    }
}
