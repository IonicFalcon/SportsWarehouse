<div class="slider">
    <div id="slideBall">
        <div class="slideDescription">
            <p>View our brand new range of</p>
            <h2>Sports Balls</h2>
            <a href="searchProducts.php?cat=5" class="linkButton">Shop Now</a>
        </div>
    </div>
    <div id="slideArmour">
        <div class="slideDescription">
            <p>Get protected with the new range of</p>
            <h2>Protective Helmets</h2>
            <a href="searchProducts.php?cat=2" class="linkButton">Shop Now</a>
        </div>
    </div>
    <div id="slideRace">
        <div class="slideDescription">
            <p>Get ready to race with our professional</p>
            <h2>Training Gear</h2>
            <a href="searchProducts.php?cat=7" class="linkButton">Shop Now</a>
        </div>
    </div>
</div>
<section class="featuredProducts productList">
    <h2>Featured Products</h2>
    <ul>
        <?php
            foreach($featuredItems as $item){
                ?>
                    <li>

                        <a href="showProduct.php?id=<?= $item->ItemID ?>" class="featuredProduct productCard">
                            <article>
                                <div class="productImage">
                                    <img src="<?= $item->ProductImage() ?>" alt="<?= $item->ItemName?> Image">
                                </div>
    
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
                                
                                <h3 class="productName"><?= $item->ItemName ?></h3>
                            </article>
                        </a>
                    </li>
                <?php
            }
        ?>
    </ul>
</section>
<section class="brandsAndPartnerships">
    <h2>Our Brands and Partnerships</h2>

    <div class="brandContent">
        <div class="brandDescription">
            <p>These are some of our top brands and partnerships.</p> 
            <p><span>The best of the best is here.</span></p>
        </div>

        <ul class="partnerships">
            <li><img src="images/partnershipLogos/logo_nike.png" alt="Nike Logo"></li>
            <li><img src="images/partnershipLogos/logo_adidas.png" alt="Adidas Logo"></li>
            <li><img src="images/partnershipLogos/logo_skins.png" alt="Skins Logo"></li>
            <li><img src="images/partnershipLogos/logo_asics.png" alt="Asics Logo"></li>
            <li><img src="images/partnershipLogos/logo_newbalance.png" alt="New Balance Logo"></li>
            <li><img src="images/partnershipLogos/logo_wilson.png" alt="Wilson Logo"></li>
        </ul>
    </div> 
</section>