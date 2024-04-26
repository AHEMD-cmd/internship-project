<?php

namespace App\Filters\Website;

use App\Helpers\QueryFilter;


class PostFilter extends QueryFilter
{
    public function title($title)
    {
        return $this->builder->where('title', 'like', "%$title%");
    }

    public function description($description)
    {
        return $this->builder->Orwhere('description', 'like', "%$description%");
    }
}
