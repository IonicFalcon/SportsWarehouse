<?php
include_once "DatabaseEntity.php";

class Item extends DatabaseEntity{
    public $ItemID;
    public $ItemName;
    public $Photo;
    public $Price;
    public $SalePrice;
    public $Description;
    public $Featured;
    public $Category;
    public $Quantity;

        
    /**
     * Return a defined image path for item's image
     *
     * @return string
     */
    public function ProductImage(){
        $defaultPath = "images/productImages/";

        if(isset($this->Photo)){
            return $defaultPath . $this->Photo;
        } else{
            return $defaultPath . "placeholder.png";
        }
    }
        
    /**
     * Return the price of item accounting for quantity and sales
     *
     * @return float
     */
    public function GetSubtotalPrice(){
        $price = 0;

        if(isset($this->SalePrice) && $this->SalePrice > 0){
            $price += $this->SalePrice * $this->Quantity;
        } else{
            $price += $this->Price * $this->Quantity;
        }

        return $price;
    }

    /**
     * Return all items from database
     *
     * @return Item[]
     */
    public static function GetAllItems(){
        include_once "Category.php";

        $query = "SELECT `ItemID`, `ItemName`, `Photo`, `Price`, `SalePrice`, `Description`, `Featured` FROM `Item`";
        $itemList = Item::DB()->ExecuteSQL($query, null, "Item");

        foreach($itemList as $item){
            $item->Category = Category::GetCategoryFromItemID($item->ItemID);
        }

        return $itemList;
    }
    
    /**
     * Return item from database given the item's ID
     *
     * @param  string $id
     * @return Item
     */
    public static function GetItemFromID($id){
        include_once "Category.php";

        $query = "SELECT `ItemID`, `ItemName`, `Photo`, `Price`, `SalePrice`, `Description`, `Featured` FROM `Item` WHERE `ItemID` = :id";
        $param = [
            ":id" => $id
        ];

        //PHP throws Notices for out of bounds errors, not errors or exception, which cannot be caught using a try catch statement
        //If query returns nothing, set item to null, else set category
        $item = Item::DB()->ExecuteSQL($query, $param, "Item")[0] ?? null;
        if ($item) $item->Category = Category::GetCategoryFromItemID($item->ItemID);

        return $item;
    }
    
    /**
     * Return all items from database marked as Featured
     *
     * @return Item[]
     */
    public static function GetFeaturedItems(){
        include_once "Category.php";

        $query = "SELECT `ItemID`, `ItemName`, `Photo`, `Price`, `SalePrice`, `Description`, `Featured` FROM `Item` WHERE `Featured` = 1";
        $itemList = Item::DB()->ExecuteSQL($query, null, "Item");

        foreach($itemList as $item){
            $item->Category = Category::GetCategoryFromItemID($item->ItemID);
        }


        return $itemList;
    }
    
    /**
     * Return an array of items given a search query. Used for when SQL query needs to be generated in the controller due to many variations in parameters to the query (e.g. Limit, Order, Category, Search Query)
     * 
     * If any other function would return the required data, DO NOT USE THIS METHOD. This method is entended to catch edge-cases. When ever possible, use a predefined method.
     * 
     * @param  string $query
     * @param  array $params
     * @return Item[]
     */
    public static function SearchForItems($query, $params = null){
        include_once "Category.php";

        $itemList = Item::DB()->ExecuteSQL($query, $params, "Item");

        foreach($itemList as $item){
            $item->Category = Category::GetCategoryFromItemID($item->ItemID);
        }

        return $itemList;
    }
    
    /**
     * Return the number of items currently stored in the database
     *
     * @return void
     */
    public static function GetItemCount(){
        $query = "SELECT COUNT(*) FROM `Item`";
        return Item::DB()->ExecuteSQLSingleVal($query);
    }
}