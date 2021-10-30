<?php

if (! function_exists("sort_url_by")) {
    function sort_url_by($request, $url, $coulmn, $direction) {
        $params = [];
        $hide = ['sort_by', 'sort'];
        foreach ($request as $key => $value) {
            if (! in_array($key, $hide)) {
                $params[$key] = $value;
            }
        }
        $params['sort_by'] = $coulmn;
        $params['sort'] = $direction;
        $query = http_build_query($params);
        return "{$url}?{$query}";
    }
}

if (! function_exists("safe_route")) {
    function safe_route($route, $parameters = [], $absolute = true) {
        try {
            return route($route, $parameters, $absolute);
        } catch (\Exception $err) {
            return "";
        }
    }
}