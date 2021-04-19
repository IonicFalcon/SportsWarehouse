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
                                
                                <div class="quantity">
                                    <label for="itemQuantity">Quantity</label>
                                    <input type="number" name="quantity" id="itemQuantity" class="itemQuantity" min="1" max="25" value=<?= $item->Quantity ?>>
                                </div>
    
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
                    <p>$<?= $shoppingCart->CalculateSubtotal() ?></p>
                </div>
                <div class="discount">
                    <p>Discount</p>
                    <p>-$<?= $shoppingCart->CalculateDiscount() ?></p>
                </div>
            </div>
    
            <div class="totalPrice">
                <p>Total</p>
                <p>$<?= $shoppingCart->CalculatePrice() ?></p>
            </div>
    
            <a href="checkout.php" id="checkout" class="linkButton">Checkout</a>
        </div>
    </div>
</section>