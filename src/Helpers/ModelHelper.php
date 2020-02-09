<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;

class ModelHelper
{

    public static function search(Builder $builder, array $columns = [], $value){
        if($value != ''){
            $builder->where(function($query) use ($columns,$value){
                foreach($columns as $column){
                    $query->orWhere($column,'like',"%$value%");
                }
            });
        }
        return $builder;
    }
    
}