<?php
include_once "DatabaseEntity.php";

class Category extends DatabaseEntity{
    public $CategoryID;
    public $CategoryName;
    
    /**
     * Get all categories from database
     *
     * @return Category[]
     */
    public static function GetAllCategories(){
        $query = "SELECT `CategoryID`, `CategoryName` FROM `category`";
        $categoryList = Category::DB()->ExecuteSQL($query, null, "Category");

        return $categoryList;
    }
    
    /**
     * Get category from databse given the category's ID
     *
     * @param  string $id
     * @return Category
     */
    public static function GetCategoryFromID($id){
        $query = "SELECT `CategoryID`, `CategoryName` FROM `category` WHERE `CategoryID` = :id";
        $param = [
            ":id" => $id
        ];

        $category = Category::DB()->ExecuteSQL($query, $param, "Category")[0] ?? null;
        return $category;
    }
    
    /**
     * Get category from database given an item ID
     *
     * @param  string $itemID
     * @return Category
     */
    public static function GetCategoryFromItemID($itemID){
        $query = "SELECT cat.CategoryID, cat.CategoryName FROM `category` AS cat, `item` WHERE item.CategoryID = cat.CategoryID AND item.ItemID = :itemID";
        $param = [
            ":itemID" => $itemID
        ];

        $category = Category::DB()->ExecuteSQL($query, $param, "Category")[0];
        return $category;
    }
}