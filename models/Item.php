<?php
include_once "DatabaseEntity.php";
include_once "Category.php";

/**
 * Model for Product Items. Includes functionality for Adding, Editting, and Deleting Items
 */
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
     * Return a defined image path for item's image. Returns a placeholder if no image was found
     *
     * @return string
     */
    public function ProductImage(){
        $defaultPath = "images/productImages/";

        if($this->Photo){
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
     * Return all Items from Database
     *
     * @return Item[]
     */
    public static function GetAllItems(){
        include_once "Category.php";

        $query = "SELECT `ItemID`, `ItemName`, `Photo`, `Price`, `SalePrice`, `Description`, `Featured` FROM `item`";
        $itemList = Item::DB()->ExecuteSQL($query, null, "Item");

        foreach($itemList as $item){
            $item->Category = Category::GetCategoryFromItemID($item->ItemID);
        }

        return $itemList;
    }
    
    /**
     * Return Item from Database given the item's ID
     *
     * @param  int $id
     * @return Item
     */
    public static function GetItemFromID($id){
        include_once "Category.php";

        $query = "SELECT `ItemID`, `ItemName`, `Photo`, `Price`, `SalePrice`, `Description`, `Featured` FROM `item` WHERE `ItemID` = :id";
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
     * Return all Items from Database marked as Featured
     *
     * @return Item[]
     */
    public static function GetFeaturedItems(){
        include_once "Category.php";

        $query = "SELECT `ItemID`, `ItemName`, `Photo`, `Price`, `SalePrice`, `Description`, `Featured` FROM `item` WHERE `Featured` = 1";
        $itemList = Item::DB()->ExecuteSQL($query, null, "Item");

        foreach($itemList as $item){
            $item->Category = Category::GetCategoryFromItemID($item->ItemID);
        }

        return $itemList;
    }
    
    /**
     * Returns all Items of a specified Category
     *
     * @param  int $catID
     * @return Item[]
     */
    public static function GetItemsOfCategory($catID){
        include_once "Category.php";

        $query = "SELECT `ItemID`, `ItemName`, `Photo`, `Price`, `SalePrice`, `Description`, `Featured` FROM `item` WHERE `categoryId` = :catID";
        $param = [
            ":catID" => $catID
        ];

        $itemList = Item::DB()->ExecuteSQL($query, $param, "Item");

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
        $query = "SELECT COUNT(*) FROM `item`";
        return Item::DB()->ExecuteSQLSingleVal($query);
    }
    
    /**
     * Add Item to Database
     *
     * @param  Item $item
     * @return void|string
     */
    public static function AddItem($item){
        $query = "INSERT INTO `item` (`itemName`, `photo`, `price`, `salePrice`, `description`, `featured`, `categoryId`) VALUES (:itemName, :photo, :price, :salePrice, :description, :featured, :catID)";
        $params = [
            ":itemName" => $item->ItemName,
            ":photo" => $item->Photo ?? [null, PDO::PARAM_NULL],
            ":price" => $item->Price,
            ":salePrice" => $item->SalePrice ?? [null, PDO::PARAM_NULL],
            ":description" => $item->Description ?? [null, PDO::PARAM_NULL],
            ":featured" => [$item->Featured, PDO::PARAM_BOOL], 
            ":catID" => $item->Category->CategoryID
        ];

        return Item::DB()->ScalarSQL($query, $params);
    }
    
    /**
     * Edited an Item in the Database
     *
     * @param  Item $item
     * @return void|string
     */
    public static function EditItem($item){
        $query = "UPDATE `item` SET `itemName` = :itemName, `photo` = :photo, `price` = :price, `salePrice` = :salePrice, `description` = :description, `featured` = :featured, `categoryId` = :catID WHERE `itemId` = :itemID";
        $params = [
            ":itemName" => $item->ItemName,
            ":photo" => $item->Photo ?? [null, PDO::PARAM_NULL],
            ":price" => $item->Price,
            ":salePrice" => $item->SalePrice ?? [null, PDO::PARAM_NULL],
            ":description" => $item->Description ?? [null, PDO::PARAM_NULL],
            ":featured" => [$item->Featured, PDO::PARAM_BOOL],
            ":catID" => $item->Category->CategoryID,
            ":itemID" => $item->ItemID
        ];

        return Item::DB()->ScalarSQL($query, $params);
    }
    
    /**
     * Removes an Item from the Database
     *
     * @param  int $itemID
     * @return void|string
     */
    public static function DeleteItem($itemID){
        $query = "DELETE FROM `item` WHERE `itemId` = :itemID";
        $param = [
            ":itemID" => $itemID
        ];

        return Item::DB()->ScalarSQL($query, $param);
    }
}