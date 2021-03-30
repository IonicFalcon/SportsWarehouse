<?php

class Item extends DatabaseEntity{
    public $ItemID;
    public $ItemName;
    public $Photo;
    public $Price;
    public $SalePrice;
    public $Description;
    public $Featured;
    public $Category;
    
    /**
     * Get all items from database
     *
     * @return Item[]
     */
    public static function GetAllItems(){
        include "Category.php";

        $query = "SELECT `ItemID`, `ItemName`, `Photo`, `Price`, `SalePrice`, `Description`, `Featured` FROM `Items`";
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
        include "Category.php";

        $query = "SELECT `ItemID`, `ItemName`, `Photo`, `Price`, `SalePrice`, `Description`, `Featured` FROM `Items` WHERE `ItemID` = :id";
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
        include "Category.php";

        $query = "SELECT `ItemID`, `ItemName`, `Photo`, `Price`, `SalePrice`, `Description`, `Featured` FROM `Items` WHERE `ItemName` LIKE :name";
        $param = [
            ":name" => "%" . $searchQuery . "%"
        ];
        
        $itemList = Item::DB()->ExecuteSQL($query, $param, "Item");

        foreach($itemList as $item){
            $item->Category = Category::GetCategoryFromItemID($item->ItemID);
        }

        return $itemList;
    }
}