<?php namespace App\AppHelpers\Transformers;

use App\AppHelpers\GlobalPropertiesFormatter;

abstract class Transformer
{
    public function transformCollection(array $items)
    {
        return array_map([$this, 'transform'], $items);
    }

    abstract public function transform($item);
}
