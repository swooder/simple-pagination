<?php

namespace Swooder\SimplePagination\Grid;

use Closure;
use Encore\Admin\Grid;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Swooder\SimplePagination\Model\Model;
use Swooder\SimplePagination\Tools\Paginator;

class SimpleGrid extends Grid
{
    protected $simple = true;

    public function __construct(Eloquent $model, Closure $builder = null)
    {
        $this->model = new Model($model, $this);
        $this->model->simple(true);
        $this->keyName = $model->getKeyName();
        $this->builder = $builder;
        $this->initialize();
        $this->callInitCallbacks();
    }

    /**
     * 是否使用 simplePaginate 方法展示分页.
     *
     * @param  bool  $value
     * @return SimpleGrid
     */
    public function simplePaginate(bool $value = true)
    {
        $this->simple = $value;

        return $this;
    }

    public function isSimple()
    {
        return $this->simple;
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
