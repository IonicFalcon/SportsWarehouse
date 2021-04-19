<?php

class ShoppingCart{
    public $Items = [];

    /**
     * Calculate Total Price of all Items in Shopping Cart
     *
     * @return string
     */
    public function CalculatePrice(){
        $price = 0;

        foreach($this->Items as $item ){
            $price += (float)$item->GetSubtotalPrice();
        }

        return number_format((float)$price, 2);
    }
    
    /**
     * Returns the subtotal of all shopping cart items (i.e. price of all items not accounting for discounts or sales)
     *
     * @return string
     */
    public function CalculateSubtotal(){
        $subtotal = 0;

        foreach($this->Items as $item){
            $subtotal += $item->Price * $item->Quantity;
        }

        return number_format((float)$subtotal, 2);
    }
    
    /**
     * Returns the discount amount of all shopping cart items
     *
     * @return string
     */
    public function CalculateDiscount(){
        return number_format((float)$this->CalculateSubtotal() - (float)$this->CalculatePrice(), 2);
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
            if($item->ItemID === $shoppingCartItem->ItemID){
                $shoppingCartItem->Quantity += $item->Quantity;
                return;
            }
        }

        array_push($this->Items, $item);
    }
}