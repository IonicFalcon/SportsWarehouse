<?php
include_once "DatabaseEntity.php";

/**
 * Model of Item Categories. Includes functionality for Add, Editing, and Deleting Categories
 */
class Category extends DatabaseEntity{
    public $CategoryID;
    public $CategoryName;
    
    /**
     * Get all Categories from Database
     *
     * @return Category[]
     */
    public static function GetAllCategories(){
        $query = "SELECT `CategoryID`, `CategoryName` FROM `category`";
        $categoryList = Category::DB()->ExecuteSQL($query, null, "Category");

        return $categoryList;
    }
    
    /**
     * Get Category from Database given the Category's ID
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
     * Get Category from Database given an Item ID
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
    
    /**
     * Add Category to the Database
     *
     * @param  string $categoryName
     * @return void|string Errors will return a string denoting error details. Normally should be void
     */
    public static function AddCategory($categoryName){
        $query = "INSERT INTO `category` (`categoryName`) VALUES (:catName)";
        $param = [
            ":catName" => $categoryName
        ];

        return Category::DB()->ScalarSQL($query, $param);
    }
    
    /**
     * Update Category in Database
     *
     * @param  int $categoryID
     * @param  string $categoryName
     * @return void|string Errors will return a string denoting error details. Normally should be void
     */
    public static function UpdateCategory($categoryID, $categoryName){
        $query = "UPDATE `category` SET `categoryName` = :catName WHERE `categoryId` = :catID";
        $params = [
            ":catName" => $categoryName,
            ":catID" => $categoryID
        ];

        return Category::DB()->ScalarSQL($query, $params);
    }
    
    /**
     * Remove a Category from the Database
     *
     * @param  int $categoryID
     * @return void|string|Exception Errors may return either a string denoted error details, or an exception in the case of violating of foreign key restraints. Normally should be void
     */
    public static function DeleteCategory($categoryID){
        $query = "DELETE FROM `category` WHERE `categoryId` = :catID";
        $param = [
            ":catID" => $categoryID
        ];

        return Category::DB()->ScalarSQL($query, $param);
    }
}