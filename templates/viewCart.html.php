<?php

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(isset($_SESSION["ShoppingCart"])){
    $shoppingCart = unserialize($_SESSION["ShoppingCart"]);
} else{
    $shoppingCart = new ShoppingCart();
}

if(isset($_SESSION["DBError"])){
    $errorMessage = $_SESSION["DBError"];
    unset($_SESSION["DBError"]);
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
                                <img src="<?= $item->ProductImage() ?>" alt="<?= htmlentities($item->ItemName) ?> Image">
                                <button class="removeItem">
                                    <span class="iconButton">Remove</span>
                                </button>                        
                            </div>
                            <div class="productInfo">
                                <h4 class="productName"><?= htmlentities($item->ItemName) ?></h4>
    
                                <?php
                                    if(isset($item->SalePrice) && floatval($item->SalePrice) > 0){
                                        ?>
                                            <div class="productPrice productSale">
                                                <span>$<?= number_format((float) $item->SalePrice, 2)  ?></span>
                                                <p>was <s>$<?= number_format((float) $item->Price, 2)  ?></s></p>
                                            </div>
                                        <?php
                                    } else{
                                        ?>
                                            <div class="productPrice">
                                                <p>$<?= number_format((float)$item->Price, 2) ?></p>
                                            </div>
                                        <?php
                                    }
                                ?>
                                
                                <div class="quantity">
                                    <label for="itemQuantity">Quantity</label>
                                    <input type="number" name="quantity" id="itemQuantity" class="itemQuantity" min="1" max="25" value=<?= $item->Quantity ?>>
                                </div>
    
                                <p class="productSubtotal">$<?= number_format((float) $item->GetSubtotalPrice(), 2) ?></p>
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
                    <p>$<?= number_format((float)$shoppingCart->CalculateSubtotal(), 2) ?></p>
                </div>
                <div class="discount">
                    <p>Discount</p>
                    <p>-$<?= number_format((float) $shoppingCart->CalculateDiscount(), 2) ?></p>
                </div>
            </div>
    
            <div class="totalPrice">
                <p>Total</p>
                <p>$<?= number_format((float) $shoppingCart->CalculatePrice(), 2) ?></p>
            </div>
    
            <a href="checkout.php" id="checkout" class="linkButton">Checkout</a>
        </div>
    </div>
</section>

<script>
    <?= isset($errorMessage) ? "console.error($errorMessage)" : null ?>
</script>