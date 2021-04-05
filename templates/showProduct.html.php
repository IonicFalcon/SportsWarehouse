<div class="productShowcase">
    <div class="breadcrumb">
        <a href="index.php" class="breadcrumb-element">Home</a>
        <a href="searchProducts.php?cat=<?= $item->Category->CategoryID ?>" class="breadcrumb-element"><?= $item->Category->CategoryName ?></a>
        <span class="breadcrumb-element"><?= $item->ItemName ?></span>
    </div>
    <div class="productInfo">
        <img src="images/productImages/<?= $item->Photo ?>" alt="<?= $item->ItemName ?> Image">
        <div class="productInfoDescription">
            <h2><?= $item->ItemName ?></h2>
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

            <p class="productDescription"><?= $item->Description ?></p>

            <form action="controllers/shoppingCartController.php" id="addToCart">
                <label for="itemQuantity">Quantity</label>
                <input type="number" name="quantity" id="itemQuantity" min="1" max="25" value="1">
                <input type="hidden" name="itemID" value="<?= $item->ItemID ?>">
                <button type="submit">
                    <p>
                        <i class="fas fa-cart-plus"></i>
                        Add to Cart
                    </p>
                    
                </button>
            </form>
        </div>
    </div>
</div>

<div class="cartModal hidden">
    <div class="cartConfirmation">
        <button class="closeConfirmation">
            <i class="fas fa-times"></i>
        </button>
        <div class="confirmationDetails">
            <img src="images/productImages/<?= $item->Photo ?>" alt="<?= $item->ItemName ?> Image">
            <h2>Item Successfully Added to Cart!</h2>
            <div class="confirmationOptions">
                <a href="searchProducts.php" id="continue" class="linkButton">Continue Shopping</a>
                <a href="viewCart.php" id="viewCart" class="linkButton">View Cart</a>
            </div>
        </div>
    </div>
</div>