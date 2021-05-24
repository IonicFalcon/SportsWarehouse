<section class="editItem">
    <?php
        if(isset($itemCategory)){
            ?>
                <div class="breadcrumb">
                    <a href="index.php" class="breadcrumb-element">Home</a>
                    <a href="editCategory.php" class="breadcrumb-element">Edit Categories</a>
                    <span class="breadcrumb-element">Edit <?= htmlentities($itemCategory->CategoryName) ?> Items</span>
                </div>
            <?php
        }
    ?>
    <table id="items" class="stripe hover row-border cell-border">
        <thead>
            <tr>
                <th>Item ID</th>
                <th>Item Name</th>
                <th>Photo</th>
                <th>Price</th>
                <th>Sale Price</th>
                <th>Description</th>
                <th>Featured</th>
                <th>Category</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data Retrieved Using AJAX -->
        </tbody>
    </table>

    <nav class="contextMenu">
        <ul>
            <li><a href="#" class="iconButton add">New Item</a></li>
            <li><a href="#" class="iconButton edit">Edit Item</a></li>
            <li><a href="#" class="iconButton delete">Delete Item</a></li>
        </ul>

        <input type="hidden" id="rowID">
        <input type="hidden" id="rowName">
        <input type="hidden" id="rowPhoto">
        <input type="hidden" id="rowPrice">
        <input type="hidden" id="rowSalePrice">
        <input type="hidden" id="rowDescription">
        <input type="hidden" id="rowFeatured">
        <input type="hidden" id="rowCategory">
    </nav>

    <div class="addModal modal">
        <div class="modalBody">
            <button class="closeConfirmation close">
                <i class="fas fa-times"></i>
            </button>

            <h2>New Item</h2>
            <p class="error"></p>

            <form action="controllers/editItemController.php" method="post" onsubmit="return false">
                <p class="formInput">
                    <input type="text" name="itemName" id="itemName_add" required>
                    <label for="itemName_add">Item Name</label>
                    <span class="inputErrors"></span>
                </p>

                <fieldset>
                    <legend>Item Photo</legend>
                    <img src="images/productImages/placeholder.png" class="itemPhoto">
                    <p class="formInput">
                        <input type="file" name="itemPhoto" id="itemPhoto_add" accept="image/*">
                        <label for="itemPhoto_add" class="linkButton">Select Item Image</label>
                        <span class="inputErrors"></span>
                    </p>
                </fieldset>

                <p class="formInput">
                    <input type="number" name="itemPrice" id="itemPrice_add" class="money" required placeholder="$9.99">
                    <label for="itemPrice_add">Item Price</label>
                    <span class="inputErrors"></span>
                </p>

                <fieldset>
                    <legend>Item Sale Price</legend>
                    <p class="formInput">
                        <input type="checkbox" id="itemOnSale_add">
                        <label for="itemOnSale_add">On Sale</label>
                        <span class="inputErrors"></span>
                    </p>

                    <p class="formInput">
                        <input type="number" name="itemSalePrice" id="itemSalePrice_add" class="money" disabled placeholder="$4.50">
                        <label for="itemSalePrice_add">Sale Price</label>
                        <span class="inputErrors"></span>
                    </p>
                </fieldset>

                <p class="formInput">
                    <textarea name="itemDescription" id="itemDescription_add" cols="30" rows="3"></textarea>
                    <label for="itemDescription_add">Item Description</label>
                    <span class="inputErrors"></span>
                </p>

                <p class="formInput">
                    <input type="checkbox" name="itemFeatured" id="itemFeatured_add">
                    <label for="itemFeatured_add">Featured Item</label>
                    <span class="inputErrors"></span>
                </p>

                <p class="formInput">
                    <select name="itemCategory" id="itemCategory_add" required>
                        <?php
                            foreach($categories as $category){
                                ?>
                                    <option value="<?= $category->CategoryID ?>"><?= htmlentities($category->CategoryName) ?></option>
                                <?php
                            }
                        ?>
                    </select>
                    <label for="itemCategory_add">Item Category</label>
                    <span class="inputErrors"></span>
                </p>

                <div class="modalButtons">
                    <button class="linkButton" id="add">Add New Item</button>
                    <button class="linkButton close">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="editModal modal <?= isset($editItem) ? "active" : null ?>">
        <div class="modalBody">
            <button class="closeConfirmation close">
                <i class="fas fa-times"></i>
            </button>

            <h2>Edit Item</h2>

            <form action="controllers/editItemController.php" method="post" onsubmit="return false">
                <p class="formInput">
                    <input type="text" name="itemName" id="itemName_edit" required value="<?= isset($editItem) ? htmlentities($editItem->ItemName) : null ?>">
                    <label for="itemName_edit">Item Name</label>
                    <span class="inputErrors"></span>
                </p>

                <fieldset>
                    <legend>Item Photo</legend>
                    <img src="<?php
                                    if(isset($editItem) && $editItem->Photo){
                                        echo "images/productImages/" . $editItem->Photo;
                                    } else{
                                        echo "images/productImages/placeholder.png";
                                    }
                                ?>" 
                         class="itemPhoto">
                    <p class="formInput">
                        <input type="file" name="itemPhoto" id="itemPhoto_edit" accept="image/*">
                        <label for="itemPhoto_edit" class="linkButton">Select Item Image</label>
                        <span class="inputErrors"></span>
                    </p>
                </fieldset>

                <p class="formInput">
                    <input type="number" name="itemPrice" id="itemPrice_edit" class="money" required placeholder="$9.99" value="<?= isset($editItem) ? htmlentities($editItem->Price) : null ?>">
                    <label for="itemPrice_edit">Item Price</label>
                    <span class="inputErrors"></span>
                </p>

                <fieldset>
                    <legend>Item Sale Price</legend>
                    <p class="formInput">
                        <input type="checkbox" id="itemOnSale_edit" <?= isset($editItem) && $editItem->SalePrice ? "checked" : null ?>>
                        <label for="itemOnSale_edit">On Sale</label>
                        <span class="inputErrors"></span>
                    </p>

                    <p class="formInput">
                        <input type="number" name="itemSalePrice" id="itemSalePrice_edit" class="money" disabled placeholder="$4.50" value="<?= isset($editItem) && $editItem->SalePrice ? htmlentities($editItem->SalePrice) : null ?>">
                        <label for="itemSalePrice_edit">Sale Price</label>
                        <span class="inputErrors"></span>
                    </p>
                </fieldset>

                <p class="formInput">
                    <textarea name="itemDescription" id="itemDescription_edit" cols="30" rows="3"><?= isset($editItem) && $editItem->Description ? $editItem->Description : null ?></textarea>
                    <label for="itemDescription_edit">Item Description</label>
                    <span class="inputErrors"></span>
                </p>

                <p class="formInput">
                    <input type="checkbox" name="itemFeatured" id="itemFeatured_edit" <?= isset($editItem) && $editItem->Featured ? "checked" : null ?>>
                    <label for="itemFeatured_edit">Featured Item</label>
                    <span class="inputErrors"></span>
                </p>

                <p class="formInput">
                    <select name="itemCategory" id="itemCategory_edit" required>
                        <?php
                            foreach($categories as $category){
                                ?>
                                    <option value="<?= $category->CategoryID ?>" <?= isset($editItem) && $editItem->Category->CategoryID === $category->CategoryID ? "selected" : null ?> ><?= htmlentities($category->CategoryName) ?></option>
                                <?php
                            }
                        ?>
                    </select>
                    <label for="itemCategory_edit">Item Category</label>
                    <span class="inputErrors"></span>
                </p>

                <div class="modalButtons">
                    <button class="linkButton" id="edit">Edit Item</button>
                    <button class="linkButton close">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <div class="deleteModal modal">
        <div class="modalBody">
            <button class="closeConfirmation close">
                <i class="fas fa-times"></i>
            </button>

            <h2>Delete Item</h2>
            <p class="error"></p>

            <form action="controllers/editItemController.php" method="post" onsubmit="return false">
                <p>Are you sure you want to delete this item?</p>

                <div class="modalButtons">
                    <button class="linkButton" id="delete">Delete Item</button>
                    <button class="linkButton close">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</section>