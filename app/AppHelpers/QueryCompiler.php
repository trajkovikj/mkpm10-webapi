<?php
/**
 * Created by PhpStorm.
 * User: srbo
 * Date: 03-Jul-16
 * Time: 3:28 PM
 */

namespace App\AppHelpers;


class QueryCompiler
{

    public function compile($query, array $params)
    {
        # foreach param search query and replace query param with the param value

        $queryPartials = explode(' ', $query);
        $resultQueryPartials = [];

        foreach ($queryPartials as $partial)
        {
            if(substr($partial, 0, 1) === "@")
            {
                foreach ($params as $paramKey => $paramValue)
                {
                    if($partial === '@'.$paramKey) array_push($resultQueryPartials, $paramValue);
                }
            }
            else
            {
                array_push($resultQueryPartials, $partial);
            }
        }

        return implode(' ', $resultQueryPartials);
    }

}