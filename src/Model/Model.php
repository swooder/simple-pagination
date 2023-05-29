<?php

namespace Swooder\SimplePagination\Model;

use Encore\Admin\Grid\Model as BaseModel;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class Model extends BaseModel
{
    /**
     * @var bool
     */
    protected $simple = false;


    /**
     * 是否使用 simplePaginate方法进行分页.
     *
     * @param bool $value
     * @return
     */
    public function simple(bool $value = true)
    {
        $this->simple = $value;

        return $this;
    }

    /**
     * @return Collection
     * @throws \Exception
     *
     */
    protected function get()
    {
        if ($this->model instanceof Paginator) {
            return $this->model;
        }

        if ($this->relation) {
            $this->model = $this->relation;
        }

        $this->setSort();
        $this->setPaginate();

        $this->queries->unique()->each(function ($query) {
            $this->model = call_user_func_array([$this->model, $query['method']], $query['arguments']);
        });

        if ($this->model instanceof Collection) {
            return $this->model;
        }

        if ($this->model instanceof Paginator) {
            return $this->model->getCollection();
        }

        if ($this->model instanceof LengthAwarePaginator) {
            $this->handleInvalidPage($this->model);

            return $this->model->getCollection();
        }

        throw new \Exception('Grid query error');
    }

    /**
     * Set the grid paginate.
     *
     * @return void
     */
    protected function setPaginate()
    {
        $paginateMethod = $this->getPaginateMethod();

        $paginate = $this->findQueryByMethod($paginateMethod);

        $this->queries = $this->queries->reject(function ($query) {
            return in_array($query['method'], ['paginate', 'simplePaginate'], true);
        });

        if (!$this->usePaginate) {
            $query = [
                'method' => 'get',
                'arguments' => [],
            ];
        } else {
            $query = [
                'method' => $paginateMethod,
                'arguments' => $this->resolvePerPage($paginate),
            ];
        }

        $this->queries->push($query);
    }

    /**
     * @return string
     */
    public function getPaginateMethod()
    {
        return $this->simple ? 'simplePaginate' : 'paginate';
    }
}
