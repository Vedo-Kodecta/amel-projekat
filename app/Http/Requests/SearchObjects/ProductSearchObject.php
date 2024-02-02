<?php

namespace App\Http\Requests\SearchObjects;

class ProductSearchObject extends BaseSearchObject
{

    public ?string $name = null;
    public ?bool $includeProductType = null;
    public ?bool $includeVariants = null;
    public ?bool $includeProductStatus = null;
    public ?int $priceGT = null;
    public ?int $priceLTE = null;
    public ?string $valid_from = null;
    public ?string $valid_to = null;

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        foreach ($attributes as $key => $value) {
       
            $this->$key = $value;
        }
    }
}