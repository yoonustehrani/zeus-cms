<?php

namespace Zeus\Traits;

trait RequestProcess
{
    protected function index_process($request, $model, $datatype, $options)
    {
        $results = $model;
        $pagination_number = (isset($options->paginate) && is_numeric($options->paginate)) ? $options->paginate : 10;
        $order_column = $request->query('sort_by') ?: $options->order_column;
        $order_direction = isset($options->order_direction) && ($options->order_direction == 'desc') ? 'desc' : 'asc';
        if ($request->query('sort')) {
            $order_direction = $request->query('sort') == 'desc' ? 'desc' : 'asc';
        }
        if ($order_column) {
            $results = $model->orderBy($order_column, $order_direction);
        }
        // Search for query
        if ($query = $request->query('q')) {
            $results = method_exists($datatype->model_name, 'scopeSearch') ? $model->search($query, null, true) : $results->where($options->default_search_key, "like", str_replace("QUERY", $request->query('q'), "%QUERY%"));
        }
        $limit = !! $request->query('limit');
        if ($limit) {
            $limit_number = ((int) $request->query('limit')) ?: 10;
            return $results->limit($limit_number)->get();
        }
        return $datatype->pagination ? $results->paginate($pagination_number) : $results->get();
    }
}