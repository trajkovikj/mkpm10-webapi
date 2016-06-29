<?php
/**
 * Created by PhpStorm.
 * User: Srbo
 * Date: 29.06.2016
 * Time: 15:23
 */

namespace App\AppHelpers;


class GlobalPropertiesFormatter
{

    public function formatRequestProperties(array $properties)
    {
        return $this->toSnakeCase($properties);
    }


    public function formatResponseProperties(array $properties)
    {
        return $this->toCamelCase($properties);
    }


    public function toCamelCase(array $properties)
    {
        $arr = [];

        foreach($properties as $key => $value)
        {
            $arr[camel_case($key)] = $value;
        }

        return $arr;
    }



    public function toSnakeCase(array $properties)
    {
        $arr = [];

        foreach($properties as $key => $value)
        {
            $arr[snake_case($key)] = $value;
        }

        return $arr;
    }
    
}