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
     * Get all items from database
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
     * Get item from database given the item's ID
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

        $item = Item::DB()->ExecuteSQL($query, $param, "Item")[0];

        $item->Category = Category::GetCategoryFromItemID($item->ItemID);
        return $item;
    }
    
    /**
     * Return a list of items based on a search query
     *
     * @param  string $searchQuery
     * @return Item[]
     */
    public static function SearchItems($searchQuery){
        include_once "Category.php";

        $query = "SELECT `ItemID`, `ItemName`, `Photo`, `Price`, `SalePrice`, `Description`, `Featured` FROM `Item` WHERE `ItemName` LIKE :name";
        $param = [
            ":name" => "%" . $searchQuery . "%"
        ];
        
        $itemList = Item::DB()->ExecuteSQL($query, $param, "Item");

        foreach($itemList as $item){
            $item->Category = Category::GetCategoryFromItemID($item->ItemID);
        }

        return $itemList;
    }

    public static function GetFeaturedItems(){
        include_once "Category.php";

        $query = "SELECT `ItemID`, `ItemName`, `Photo`, `Price`, `SalePrice`, `Description`, `Featured` FROM `Item` WHERE `Featured` = 1";
        $itemList = Item::DB()->ExecuteSQL($query, null, "Item");

        foreach($itemList as $item){
            $item->Category = Category::GetCategoryFromItemID($item->ItemID);
        }


        return $itemList;
    }
}