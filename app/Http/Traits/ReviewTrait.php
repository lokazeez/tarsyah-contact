<?php

namespace App\Http\Traits;


trait ReviewTrait {

    public function getModelType($model_type): string
    {
        switch ($model_type){
            case 'product':
                return 'App\Models\Product';
 
            default:
                return '';
        }
    }

    public function getFavoritesByModelName($user, $type)
    {
        switch ($type){
            case 'product':
                return $user->ProductReviews();

            default:
                return $user->ProductReviews();
        }
    }
}
