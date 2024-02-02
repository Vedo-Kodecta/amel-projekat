<?php

namespace App\Http\Requests\SearchObjects;

use App\Traits\PaginationTrait;
use Illuminate\Foundation\Http\FormRequest;

class BaseSearchObject extends FormRequest
{
    use PaginationTrait;

    public function __construct($attributes = [])
    {
        parent::__construct();
        foreach ($attributes as $key => $value) {
            $this->$key = $value;
        }
    }
}