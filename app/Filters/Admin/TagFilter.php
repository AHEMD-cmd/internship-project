<?php

namespace App\Filters\Admin;

use App\Helpers\QueryFilter;


class TagFilter extends QueryFilter
{
    public function name($name)
    {
        return $this->builder->where('name', 'like', "%$name%");
    }
}
