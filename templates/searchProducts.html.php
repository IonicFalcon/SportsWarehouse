<section class="itemSearch">
    <div class="breadcrumb">
        <a href="index.php" class="breadcrumb-element">Home</a>
        <?php
            if(isset($category)){
                ?>
                    <span class="breadcrumb-element"><?= $category->CategoryName ?></span>
                <?php
            } else{
                ?>
                    <span class="breadcrumb-element">Search Results</span>
                    <span class="breadcrumb-element"><?= htmlentities($_GET["search"]) ?></span>
                <?php
            }
        ?>
    </div>

    <?php
        if(isset($category)){
            ?>
                <h2><?= $category->CategoryName ?></h2>
            <?php
        }
    ?>

    <div class="searchOptions">
        <label class="buttonLabel">Sort By</label>
        <form method="get">
            <select name="sort" id="sortOption">
                <option value="AToZ" <?= FormValidator::SetSelected("sort", "AToZ") ?>>A-Z</option>
                <option value="ZToA" <?= FormValidator::SetSelected("sort", "ZToA") ?>>Z-A</option>
                <option value="priceLow" <?= FormValidator::SetSelected("sort", "priceLow") ?>>Price Low-High</option>
                <option value="priceHigh" <?= FormValidator::SetSelected("sort", "priceHigh") ?>>Price High-Low</option>
                <option value="featured" <?= FormValidator::SetSelected("sort", "featured") ?>>Featured Product</option>
            </select>
            <input type="hidden" name="cat" value="<?= isset($category) ? $category->CategoryID : "" ?>">
            <input type="hidden" name="search" value="<?= isset($_GET['search']) ? $_GET['search'] : "" ?>">
            
        </form>
    </div>
    
    <?php
        if(sizeof($items) == 0){
            ?>
                <p class="searchError">
                    Sorry, no products were found matching your search or filters. Please double check your search before trying again.
                </p>
            <?php
        }
    ?>
    <ul class="productList">
        <?php
            foreach($items as $item){
                ?>
                    <li>
                        <a href="showProduct.php?id=<?= $item->ItemID ?>" class="productCard">
                            <article>
                                <div class="productImage">
                                    <img src="<?= $item->ProductImage() ?>" alt="<?= $item->ItemName?> Image">
                                </div>
    
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
                                
                                <h3 class="productName"><?= $item->ItemName ?></h3>
                            </article>
                        </a>
                    </li>
                <?php
            }
        ?>
    </ul>
</section>