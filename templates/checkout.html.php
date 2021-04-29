<?php

session_start();

if(isset($_SESSION["ShoppingCart"])){
    $shoppingCart = unserialize($_SESSION["ShoppingCart"]);
} else{
    header("Location: index.php");
    die();
}

?>

<div class="breadcrumb">
    <a href="viewCart.php" id="returnToCart" class="breadcrumb-element">Back to Cart</a>
</div>

<section class="checkout">
    <div class="checkoutContainer">
        <div class="shippingDetails">
            <h2 class="collapsible">Shipping</h2>
            <form action="controllers/checkoutController.php" method="post" id="shippingInfo" onsubmit="return false">
                <p class="formInput">
                    <input type="text" name="FirstName" id="firstName" placeholder="John" required>
                    <label for="firstName">First Name</label>
                    <span class="inputErrors"></span>
                </p>
                <p class="formInput">
                    <input type="text" name="LastName" id="lastName" placeholder="Smith" required>
                    <label for="lastName">Last Name</label>
                    <span class="inputErrors"></span>
                </p>
                <p class="formInput">
                    <input type="text" name="Address" id="address" placeholder="123 Street Dr, Sydney NSW 2000" required>
                    <label for="address">Delivery Address</label>
                    <span class="inputErrors"></span>
                </p>
                <p class="formInput">
                    <input type="tel" name="ContactNumber" id="contact" placeholder="0404 040 040" required>
                    <label for="contact">Contact Number</label>
                    <span class="inputErrors"></span>
                </p>
                <p class="formInput">
                    <input type="email" name="Email" id="email" placeholder="john.smith@email.com" required>
                    <label for="email">Email</label>
                    <span class="inputErrors"></span>
                </p>
                
                <button id="gotoPayment" class="linkButton">Continue to Payment</button>
            </form>
        </div>
    
        <div class="paymentDetails">
            <h2 class="collapsible collapsed">Payment</h2>
            <form action="controllers/checkoutController.php" method="post" id="paymentInfo" class="collapsed" onsubmit="return false">
                <p class="formInput">
                    <input type="text" name="CreditCardNumber" id="creditCard" pattern="\d{16}" maxlength="16" required placeholder="0000 0000 0000 0000">
                    <label for="creditCard">Credit Card Number</label>
                    <span class="inputErrors"></span>
                </p>
                <div class="expiry">
                    <div class="expiryMonth formInput">
                        <input type="text" name="ExpiryMonth" id="expiryMonth" pattern="\d*" maxlength="2" required placeholder="MM" required>
                        <label for="expiryMonth">Expiry Month</label>
                        <span class="inputErrors"></span>
                    </div>
                    <div class="expiryYear formInput">
                        <input type="text" name="ExpiryYear" id="expiryYear" pattern="\d*" maxlength="2" required placeholder="YY">
                        <label for="expiryYear">Expiry Year</label>
                        <span class="inputErrors"></span>
                    </div>
                </div>
                <p class="formInput">
                    <input type="text" name="CSV" id="CVV" pattern="\d{3}" maxlength="3" placeholder="000" required>
                    <label for="CVV">CVV</label>
                    <span class="inputErrors"></span>
                </p>
                <p class="formInput">
                    <input type="text" name="NameOnCard" id="cardName" placeholder="John Smith" required>
                    <label for="cardName">Name on Card</label>
                    <span class="inputErrors"></span>
                </p>
    
                <button id="placeOrder" class="linkButton">Place Order</button>
            </form>
        </div>
    </div>
    <div class="shoppingCartSummary">
        <h2>Order Summary</h2>
        <h3>Products</h3>
        <?php
            foreach($shoppingCart->Items as $item){
                ?>
                    <div class="cartItem">
                        <div class="productImage">
                            <img src="<?= $item->ProductImage() ?>" alt="<?= $item->ItemName ?> Image">
                        </div>
                        <div class="productInfo">
                            <h4 class="productName"><?= $item->ItemName ?></h3>
                            <p class="productQuantity">Quantity: <?= $item->Quantity ?></p>
                            <p class="productSubtotal">$<?= number_format((float) $item->GetSubtotalPrice(), 2) ?></p>
                        </div>
                    </div>
                <?php
            }
        ?>

        <h3>Summary</h3>
        <div class="priceCalculation">
            <div class="subtotal">
                <p>Subtotal</p>
                <p>$<?= number_format((float) $shoppingCart->CalculateSubtotal(), 2) ?></p>
            </div>
            <div class="discount">
                <p>Discount</p>
                <p>-$<?= number_format((float) $shoppingCart->CalculateDiscount(), 2) ?></p>
            </div>
        </div>

        <div class="totalPrice">
            <p>Order Total</p>
            <p>$<?= number_format((float) $shoppingCart->CalculatePrice(), 2) ?></p>
        </div>
    </div>
</section>