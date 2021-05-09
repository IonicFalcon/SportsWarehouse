<?php

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(isset($_SESSION["OrderDetails"])){
    $order = unserialize($_SESSION["OrderDetails"]);
    unset($_SESSION["OrderDetails"]);
} else{
    header("Location: index.php");
    die();
}

?>

<section class="orderConfirm">
    <h2>Order Received</h2>
    <p>Thank you! Your order has been received and is now out for processing. Please shop again at Sports Warehouse!</p>

    <ul class="orderOverview">
        <li>
            <p>Order Number</p>
            <strong><?= $order->OrderID ?></strong>
        </li>
        <li>
            <p>Date</p>
            <strong><?= $order->OrderDate->format("j F, Y") . " at " . $order->OrderDate->format("g:iA") ?></strong>
        </li>
        <li>
            <p>Total</p>
            <strong>$<?= number_format((float)$order->Cart->CalculatePrice(), 2) ?></strong>
        </li>
    </ul>

    <h3>Order Details</h3>
    <table class="orderDetails">
        <thead>
            <tr>
                <th>Product</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($order->Cart->Items as $item){
                ?>
                    <tr>
                        <td><a href="showProduct.php?id=<?= $item->ItemID ?>"><?= $item->ItemName ?></a> &times; <?= $item->Quantity ?></td>
                        <td>$<?= number_format((float) $item->GetSubtotalPrice(), 2) ?></td>
                    </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <div class="priceCalculation">
        <div class="subtotal">
            <p>Subtotal</p>
            <p>$<?= number_format((float) $order->Cart->CalculateSubtotal(), 2) ?></p>
        </div>
        <div class="discount">
            <p>Discount</p>
            <p>-$<?= number_format((float) $order->Cart->CalculateDiscount(), 2) ?></p>
        </div>
    </div>

    <div class="totalPrice">
        <p>Order Total</p>
        <p>$<?= number_format((float) $order->Cart->CalculatePrice(), 2) ?></p>
    </div>
</section>