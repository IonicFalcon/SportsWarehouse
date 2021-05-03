<?php
include_once "DatabaseEntity.php";
include_once "ShoppingCart.php";

class Order extends DatabaseEntity{
    public $OrderID;
    public $OrderDate;
    public $FirstName;
    public $LastName;
    public $Address;
    public $ContactNumber;
    public $Email;
    public $CreditCardNumber;
    public $ExpiryDate;
    public $NameOnCard;
    public $CSV;
    public $Cart;

    public function __construct($orderInfo, $cart)
    {
        foreach($orderInfo as $key => $value){
            if(property_exists("Order", $key)){
                $this->{$key} = $value;
            }
        }

        $expiryDate = $orderInfo["ExpiryMonth"] . "/" . $orderInfo["ExpiryYear"];
        
        $this->ExpiryDate = $expiryDate;
        $this->Cart = $cart;
    }

    public function ProcessOrder(){
        $this->OrderDate = new DateTime();

        $query = "INSERT INTO `shoppingorder` (`orderDate`, `firstName`, `lastName`, `address`, `contactNumber`, `email`, `creditCardNumber`, `expiryDate`, `nameOnCard`, `csv`) VALUES (:orderDate, :firstName, :lastName, :address, :contactNumber, :email, :creditCard, :expiryDate, :cardName, :csv)";
        $params = [
            ":orderDate" => $this->OrderDate->format("Y-m-d H:i:s"),
            ":firstName" => $this->FirstName,
            ":lastName" => $this->LastName,
            ":address" => $this->Address,
            ":contactNumber" => $this->ContactNumber,
            ":email" => $this->Email,
            ":creditCard" => $this->CreditCardNumber,
            ":expiryDate" => $this->ExpiryDate,
            ":cardName" => $this->NameOnCard,
            ":csv" => $this->CSV
        ];

        $returnMessage = Order::DB()->ScalarSQLReturnID($query, $params);

        if($returnMessage[0]){
            $this->OrderID = $returnMessage[1];

            foreach($this->Cart->Items as $item){
                $errorMessage = Order::InsertOrderItem($item, $this->OrderID);

                if($errorMessage) return $errorMessage;
            }

        } else{
            return $returnMessage[1];
        }
    }


    private static function InsertOrderItem($item, $orderID){
        $query = "INSERT INTO `orderitem`(`itemId`, `shoppingOrderId`, `quantity`, `price`) VALUES (:itemID, :orderID, :quantity, :price)";
        $params = [
            ":itemID" => $item->ItemID,
            ":orderID" => $orderID,
            ":quantity" => $item->Quantity,
            ":price" => isset($item->SalePrice) && $item->SalePrice > 0 ? $item->SalePrice : $item->Price
        ];

        return Order::DB()->ScalarSQL($query, $params);
    }


}