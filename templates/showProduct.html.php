<div class="productShowcase">
    <div class="breadcrumb">
        <a href="index.php" class="breadcrumb-element">Home</a>
        <a href="searchProducts.php?cat=<?= $item->Category->CategoryID ?>" class="breadcrumb-element"><?= htmlentities($item->Category->CategoryName) ?></a>
        <span class="breadcrumb-element"><?= htmlentities($item->ItemName) ?></span>
    </div>
    <div class="productInfo">
        <img src="<?= $item->ProductImage() ?>" alt="<?= htmlentities($item->ItemName) ?> Image">
        <div class="productInfoDescription">
            <h2><?= htmlentities($item->ItemName) ?></h2>
            <?php
                if(isset($item->SalePrice) && floatval($item->SalePrice) > 0){
                    ?>
                        <div class="productPrice productSale">
                            <span>$<?= number_format((float) $item->SalePrice, 2) ?></span>
                            <p>was <s>$<?= number_format((float) $item->Price, 2) ?></s></p>
                        </div>
                    <?php
                } else{
                    ?>
                        <div class="productPrice">
                            <p>$<?= number_format((float) $item->Price, 2) ?></p>
                        </div>
                    <?php
                }
            ?>

            <p class="productDescription"><?= htmlentities($item->Description) ?></p>

            <?php
                if(isset($admin)){
                    ?>
                        <a href="editProduct.php?id=<?= $item->ItemID ?>&cat=<?= $item->Category->CategoryID ?>" class="linkButton">
                            <i class="fas fa-edit"></i>
                            Edit Item
                        </a>
                    <?php
                } else{
                    ?>
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

                    <?php
                }
            ?>

        </div>
    </div>
</div>

<div class="cartModal modal">
    <div class="cartConfirmation modalBody">
        <button class="closeConfirmation">
            <i class="fas fa-times"></i>
        </button>
        <div class="confirmationDetails">
            <img src="<?= $item->ProductImage() ?>" alt="<?= htmlentities($item->ItemName) ?> Image">
            <h2>Item Successfully Added to Cart!</h2>
            <div class="confirmationOptions modalButtons">
                <a href="searchProducts.php?cat=<?= $item->Category->CategoryID ?>" id="continue" class="linkButton">Continue Shopping</a>
                <a href="viewCart.php" id="viewCart" class="linkButton">View Cart</a>
            </div>
        </div>
    </div>
</div>