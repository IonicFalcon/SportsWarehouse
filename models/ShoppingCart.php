<?php

class ShoppingCart{
    public $Items = [];

    /**
     * Calculate Total Price of all Items in Shopping Cart
     *
     * @return float
     */
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

    /**
     * Return formatted size of Shopping Cart size
     *
     * @return string
     */
    public function ItemCount(){
        $itemAmount = 0;

        foreach($this->Items as $item){
            $itemAmount += $item->Quantity;
        }

        if($itemAmount == 1){
            return $itemAmount . " Item";
        } else{
            return $itemAmount . " Items";
        }
    }

    /**
     * Add Item to Shopping Cart. If Item already exists, add the quantities together
     *
     * @param Item $item
     * @return void
     */
    public function AddItem($item){
        foreach($this->Items as $shoppingCartItem){
            if($item->ItemID === $shoppingCartItem){
                $shoppingCartItem->Quantity += $item->Quantity;
                return;
            }
        }

        array_push($this->Items, $item);
    }
}