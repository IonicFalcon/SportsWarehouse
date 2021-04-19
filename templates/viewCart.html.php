<?php

session_start();

if(isset($_SESSION["ShoppingCart"])){
    $shoppingCart = unserialize($_SESSION["ShoppingCart"]);
} else{
    $shoppingCart = new ShoppingCart();
}

?>

<section class="shoppingCart">
    <h2>Shopping Cart</h2>

    <div class="cartDetails">
        <div class="shoppingCartItems">
            <h3>Products</h3>
            <?php
                foreach($shoppingCart->Items as $item){
                    ?>
                        <div class="cartItem">
                            <div class="productImage">
                                <img src="<?= $item->ProductImage() ?>" alt="<?= $item->ItemName ?> Image">
                                <button class="removeItem">
                                    <span class="iconButton">Remove</span>
                                </button>                        
                            </div>
                            <div class="productInfo">
                                <h4 class="productName"><?= $item->ItemName ?></h4>
    
                                <?php
                                    if(isset($item->SalePrice) && floatval($item->SalePrice) > 0){
                                        ?>
                                            <div class="productPrice productSale">
                                                <span>$<?= $item->SalePrice ?></span>
                                                <p>was <s>$<?= $item->Price ?></s></p>
                                            </div>
                                        <?php
                                    } else{
                                        ?>
                                            <div class="productPrice">
                                                <p>$<?= $item->Price ?></p>
                                            </div>
                                        <?php
                                    }
                                ?>
    
                                <input type="number" name="quantity" id="itemQuantity" min="1" max="25" value=<?= $item->Quantity ?>>
    
                                <p class="productSubtotal">$<?= $item->GetSubtotalPrice() ?></p>
                            </div>
                        </div>
                    <?php
                }
            ?>
        </div>
    
        <div class="shoppingCartSummary">
            <h3>Summary</h3>
    
            <div class="priceCalculation">
                <div class="subtotal">
                    <p>Subtotal</p>
                    <p>
                        <?php
                            $subtotal = 0;
    
                            foreach($shoppingCart->Items as $item){
                                $subtotal += $item->Price * $item->Quantity;
                            }
                            
                            echo "$" . $subtotal;
    
                            $totalPrice = $shoppingCart->CalculatePrice();
                            $discount = $subtotal - $totalPrice;
                        ?>
                    </p>
                </div>
                <?php
                    if ($discount > 0){
                        ?>
                            <div class="discount">
                                <p>Discount</p>
                                <p>-$<?= $discount ?></p>
                            </div>
                        <?php
                    }
                ?>
            </div>
    
            <div class="totalPrice">
                <p>Total</p>
                <p>$<?= $totalPrice ?></p>
            </div>
    
            <a href="checkout.php" id="checkout" class="linkButton">Checkout</a>
        </div>
    </div>
</section>