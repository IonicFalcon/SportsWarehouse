<?php

class ShoppingCart{
    public $Items = [];

    public function CalculatePrice(){
        $price = 0;

        foreach($this->Items as $item ){
            if(isset($item->SalePrice) && $item->SalePrice > 0){
                $price += $item->SalePrice * $item->Quantity;
            } else{
                $price += $item->Price * $item->Quantity;
            }
        }

        return $price;
    }
}