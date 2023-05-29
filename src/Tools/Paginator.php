<?php

namespace Swooder\SimplePagination\Tools;

use Encore\Admin\Grid\Tools\Paginator as BasePaginator;
use Encore\Admin\Grid\Tools\PerPageSelector;
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
        return $this->paginator->render('simplepagination::pagination');
    }
}
