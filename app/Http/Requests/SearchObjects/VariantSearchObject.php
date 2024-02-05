<?php

namespace App\Http\Requests\SearchObjects;

class VariantSearchObject extends BaseSearchObject
{
    public ?bool $includeProduct = null;

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        foreach ($attributes as $key => $value) {
            $this->$key = $value;
        }
    }
}
