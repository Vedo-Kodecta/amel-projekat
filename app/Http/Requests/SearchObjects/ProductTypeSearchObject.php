<?php

namespace App\Http\Requests\SearchObjects;

class ProductTypeSearchObject extends BaseSearchObject
{
    public ?string $name = '';

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        foreach ($attributes as $key => $value) {
            $this->$key = $value;
        }
    }
}
