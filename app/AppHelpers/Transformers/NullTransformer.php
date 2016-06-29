<?php namespace App\AppHelpers\Transformers;


use App\AppHelpers\GlobalPropertiesFormatter;

class NullTransformer extends Transformer {

    public function transform($item)
    {
        $formatter = new GlobalPropertiesFormatter();
        return $formatter->formatResponseProperties($item);
    }
}
