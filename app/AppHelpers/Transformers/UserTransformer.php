<?php
/**
 * Created by PhpStorm.
 * User: srbo
 * Date: 19-Jun-16
 * Time: 7:14 PM
 */

namespace app\AppHelpers\Transformers;


class UserTransformer extends Transformer
{
    public function transform($item)
    {
        return [
            'id' => $item['id'],
            'name' => $item['name'],
            'email' => $item['email']
        ];
    }
}