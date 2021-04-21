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
            $price += (float)$item->GetSubtotalPrice();
        }

        return $price;
    }
    
    /**
     * Returns the subtotal of all shopping cart items (i.e. price of all items not accounting for discounts or sales)
     *
     * @return float
     */
    public function CalculateSubtotal(){
        $subtotal = 0;

        foreach($this->Items as $item){
            $subtotal += $item->Price * $item->Quantity;
        }

        return $subtotal;
    }
    
    /**
     * Returns the discount amount of all shopping cart items
     *
     * @return float
     */
    public function CalculateDiscount(){
        return $this->CalculateSubtotal() - $this->CalculatePrice();
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