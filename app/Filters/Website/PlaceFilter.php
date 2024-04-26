<?php

namespace App\Filters\Website;

use App\Helpers\QueryFilter;


class PlaceFilter extends QueryFilter
{
    public function title($name)
    {
        return $this->builder->where('name', 'like', "%$name%");
    }

    public function description($description)
    {
        return $this->builder->Orwhere('description', 'like', "%$description%");
    }
}
