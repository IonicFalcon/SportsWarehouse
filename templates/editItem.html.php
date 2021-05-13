<section class="editItem">
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
                </p>

                <fieldset>
                    <legend>Item Photo</legend>
                    <img src="images/productImages/placeholder.png" class="itemPhoto">
                    <p class="formInput">
                        <input type="file" name="itemPhoto" id="itemPhoto_add" accept="image/*">
                        <label for="itemPhoto_add" class="linkButton">Select Item Image</label>
                    </p>
                </fieldset>

                <p class="formInput">
                    <input type="number" name="itemPrice" id="itemPrice_add" class="money" required placeholder="$9.99">
                    <label for="itemPrice_add">Item Price</label>
                </p>

                <fieldset>
                    <legend>Item Sale Price</legend>
                    <p class="formInput">
                        <input type="checkbox" id="itemOnSale">
                        <label for="itemOnSale">On Sale</label>
                    </p>

                    <p class="formInput">
                        <input type="number" name="itemSalePrice" id="itemSalePrice_add" class="money" disabled placeholder="$4.50">
                        <label for="itemSalePrice_add">Sale Price</label>
                    </p>
                </fieldset>

                <p class="formInput">
                    <textarea name="itemDescription" id="itemDescription_add" cols="30" rows="3"></textarea>
                    <label for="itemDescription_add">Item Description</label>
                </p>

                <p class="formInput">
                    <input type="checkbox" name="itemFeatured" id="itemFeatured_add">
                    <label for="itemFeatured_add">Featured Item</label>
                </p>

                <p class="formInput">
                    <select name="itemCategory" id="itemCategory_add">
                        <?php
                            foreach($categories as $category){
                                ?>
                                    <option value="<?= $category->CategoryID ?>"><?= $category->CategoryName ?></option>
                                <?php
                            }
                        ?>
                    </select>
                    <label for="itemCategory_add">Item Category</label>
                </p>

                <div class="modalButtons">
                    <button class="linkButton" id="add">Add New Item</button>
                    <button class="linkButton close">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</section>