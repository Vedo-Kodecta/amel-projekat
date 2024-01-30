<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

trait PaginationTrait
{
    public function applyPagination(Builder $query)
    {
        $items = $query->get();
        $perPage = (int)request('per_page', 6);
        $page = Paginator::resolveCurrentPage() ?: 1;
        $total = count($items);
        $offset = ($page * $perPage) - $perPage;
        $itemstoshow = $items->slice($offset, $perPage);

        return new LengthAwarePaginator($itemstoshow, $total, $perPage);
    }
}
