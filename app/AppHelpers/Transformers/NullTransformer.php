<?php namespace App\AppHelpers\Transformers;


class NullTransformer extends Transformer {

    public function transform($item)
    {
        return $item;
    }
}
