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
            <select name="limit" id="sortLimit">
                <option value="6" <?= FormValidator::SetSelected("limit", "6") ?>>6</option>
                <option value="12" <?= FormValidator::SetSelected("limit", "12") ?>>12</option>
                <option value="18" <?= FormValidator::SetSelected("limit", "18") ?>>18</option>
                <option value="24" <?= FormValidator::SetSelected("limit", "24") ?>>24</option>
                <option value="30" <?= FormValidator::SetSelected("limit", "30") ?>>30</option>
                <option value="36" <?= FormValidator::SetSelected("limit", "36") ?>>36</option>
            </select>
            <input type="hidden" name="cat" value="<?= isset($category) ? $category->CategoryID : "" ?>">
            <input type="hidden" name="search" value="<?= isset($_GET['search']) ? $_GET['search'] : "" ?>">
            
        </form>
        <nav class="searchNavigation">
            <p>Displaying <?= $searchStart ?> - <?= $searchEnd ?> of <?= $totalItems ?></p>
            <ul>
                <?php
                    if($searchStart != 1){
                        ?>
                            <li>
                                <a href="">
                                    <i class="fas fa-fast-backward"></i>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="fas fa-step-backward"></i>
                                </a>
                            </li>
                        <?php
                    }

                    $pageIndex = 1;
                    for($i = 0; $i < $totalItems; $i++){
                        if($i % $limit == 0){
                            ?>
                                <li>
                                    <a href="">
                                        <?= $pageIndex ?>
                                    </a>
                                </li>
                            <?php
                            $pageIndex++;
                        }
                    }

                    if($searchEnd != $totalItems){
                        ?>
                            <li>
                                <a href="">
                                    <i class="fas fa-step-forward"></i>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="fas fa-fast-forward"></i>
                                </a>
                            </li>
                        <?php
                    }
                ?>
            </ul>
        </nav>
    </div>
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
    <nav class="searchNavigation">
        <ul>
            <?php
                if($searchStart != 1){
                    ?>
                        <li>
                            <a href="">
                                <i class="fas fa-fast-backward"></i>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <i class="fas fa-step-backward"></i>
                            </a>
                        </li>
                    <?php
                }

                $pageIndex = 1;
                for($i = 0; $i < $totalItems; $i++){
                    if($i % $limit == 0){
                        ?>
                            <li>
                                <a href="">
                                    <?= $pageIndex ?>
                                </a>
                            </li>
                        <?php
                        $pageIndex++;
                    }
                }

                if($searchEnd != $totalItems){
                    ?>
                        <li>
                            <a href="">
                                <i class="fas fa-step-forward"></i>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <i class="fas fa-fast-forward"></i>
                            </a>
                        </li>
                    <?php
                }
            ?>
        </ul>
    </nav>
</section>