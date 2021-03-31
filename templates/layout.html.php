<?php
    session_start();

    if(isset($_SESSION["ShoppingCart"])){
        include "models/ShoppingCart.php";
        
        $shoppingCart = unserialize($_SESSION["ShoppingCart"]);
        $cartSize = sizeof($shoppingCart->Items);
    } else{
        $cartSize = 0;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/0b7408c7cc.js" crossorigin="anonymous"></script>

    <?php
        //Import any other relevant files for the specific page
        if(isset($CSSSources)){
            foreach($CSSSources as $file){
                ?>
                    <link rel="stylesheet" href="<?= $file ?>">
                <?php
            }
        }
    ?>

</head>
<body>
    <div class="root">
        <header class="siteHeader">
            <div class="topBar">
                <div class="wrapper">
                    <div class="hamburgerMenu">
                        <input type="checkbox" name="mobileHamburger" id="mobileHamburger" onchange="mobileMenu(this)">
                        <label for="mobileHamburger" class="iconButton hamburgerIcon">Menu</label>
                    </div>
    
                    <nav class="siteNav desktopNav">
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li><a href="#">About SW</a></li>
                            <li><a href="#">Contact Us</a></li>
                            <li><a href="searchProducts.php">View Products</a></li>
                        </ul>               
                    </nav>
    
                    <div class="userOptions">
                        <a href="#" class="login iconButton">Login</a>
                        <a href="#" class="viewCart iconButton">
                            <p>View Cart</p>
                            <span class="cartTotal"><?= $cartSize ?> Item/s</span>
                        </a>
                    </div>
                </div>
            </div>

            <nav class="mobileNav siteNav">
                <ul>
                    <li><a href="#" class="login iconButton">Login</a></li>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#">About SW</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="searchProducts.php">View Products</a></li>
                </ul>  
            </nav>

            <div class="siteBanner wrapper">
                <a href="index.php" class="siteLogo" aria-label="Sports Warehouse">
                    <img src="images/LogoLarge.gif" alt="Sports Warehouse Logo">
                </a>
            
                <form method="get" class="search">
                    <input type="text" name="search" id="searchBox" aria-label="Search Products" placeholder="Search Products">
                    <button type="submit" class="searchButton" aria-label="Search">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            <div class="categoryBar wrapper">
                <nav class="categoryNav">
                    <ul>
                        <?php
                            foreach($categories as $category){
                                ?>
                                    <li><a href="searchProducts.php?cat=<?= $category->CategoryID ?>"><?= $category->CategoryName ?></a></li>
                                <?php
                            }
                        ?>
                    </ul>
                </nav>
            </div>
        </header>
        <main class="wrapper">
            <?= $mainOutput ?>
        </main>
        <footer class="siteFooter">
        <div class="wrapper">
                <div class="footerGroups">
                    <div class="footerSiteNav">
                        <nav class="siteNav">
                            <h2>Site Navigation</h2>
                            <ul>
                                <li><a href="index.php">Home</a></li>
                                <li><a href="#">About SW</a></li>
                                <li><a href="#">Contact Us</a></li>
                                <li><a href="searchProducts.php">View Products</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="footerProductCategories">
                        <nav class="categoryNav">
                            <h2>Product Categories</h2>
                            <ul>
                                <?php
                                    foreach($categories as $category){
                                        ?>
                                            <li><a href="searchProducts.php?cat=<?= $category->CategoryID ?>"><?= $category->CategoryName ?></a></li>
                                        <?php
                                    }
                                ?>
                            </ul>
                        </nav>
                    </div>
                    <div class="footerContact">
                        <h2>Contact Sports Warehouse</h2>
                        <ul>
                            <li>
                                <a href="#" id="contactFacebook" class="contactIcon">
                                    <div class="iconCircle">
                                        <i class="fab fa-facebook-f"></i>
                                    </div>
                                    <p>Facebook</p>
                                </a>
                            </li>
                            <li>
                                <a href="#" id="contactTwitter" class="contactIcon">
                                    <div class="iconCircle">
                                        <i class="fab fa-twitter"></i>
                                    </div>
                                    <p>Twitter</p>
                                </a>
                            </li>
                            <li>
                                <a href="#" id="contactOther" class="contactIcon">
                                    <div class="iconCircle">
                                        <i class="fas fa-paper-plane"></i>
                                    </div>
                                    <p>Other</p>
                                    <ul>
                                        <li>Online Form</li>
                                        <li>Email</li>
                                        <li>Phone</li>
                                        <li>Address</li>
                                    </ul>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="copyrightDetails">
                <small>
                    <p>&copy; Copyright 2020 Sports Warehouse.</p>
                    <p>All rights reserved.</p>
                    <p>Website made by Awesomesauce Design</p>
                </small>
            </div>
        </footer>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="js/layout.js"></script>
    <?php
        //Import any other relevant files for the specific page
        if(isset($JSSources)){
            foreach($JSSources as $file){
                ?>
                    <script src="<?=$file?>"></script>
                <?php
            }
        }
    ?>
</body>
</html>