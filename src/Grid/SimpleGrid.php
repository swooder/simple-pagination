<?php

namespace Swooder\SimplePagination\Grid;

use Closure;
use Encore\Admin\Grid;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Swooder\SimplePagination\Model\Model;
use Swooder\SimplePagination\Tools\Paginator;

class SimpleGrid extends Grid
{
    public function __construct(Eloquent $model, Closure $builder = null)
    {
        $this->model = new Model($model, $this);
        $this->keyName = $model->getKeyName();
        $this->builder = $builder;
        $this->initialize();
        $this->callInitCallbacks();
        $this->simplePaginate(true);
    }

    /**
     * 是否使用 simplePaginate 方法分页.
     *
     * @param  bool  $value
     * @return SimpleGrid
     */
    public function simplePaginate(bool $value = true)
    {
        $this->model()->simple($value);

        return $this;
    }


    /**
     * Get Grid model.
     *
     * @return Model|\Illuminate\Database\Eloquent\Builder
     */
    public function model()
    {
        return $this->model;
    }

    /**
     * Get the grid paginator.
     *
     * @return mixed
     */
    public function paginator()
    {
        return new Paginator($this, $this->options['show_perpage_selector']);
    }
}
