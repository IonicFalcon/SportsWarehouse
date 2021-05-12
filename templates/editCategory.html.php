<section class="editCategory">
    <table id="categories" class="stripe hover row-border cell-border">
        <thead>
            <tr>
                <th>Category ID</th>
                <th>Category Name</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data Retreived Using AJAX -->
        </tbody>
    </table>

    <nav class="contextMenu">
        <ul>
            <li><a href="#" class="iconButton add">New Category</a></li>
            <li><a href="#" class="iconButton edit">Edit Category</a></li>
            <li><a href="#" class="iconButton delete">Delete Category</a></li>
        </ul>
        <input type="hidden" id="rowID" value="<?= isset($editCategory) ? $editCategory->CategoryID : null ?>">
        <input type="hidden" id="rowName" value="<?= isset($editCategory) ? $editCategory->CategoryName : null ?>">
    </nav>

    <div class="addModal modal">
        <div class="modalBody">
            <button class="closeConfirmation close">
                <i class="fas fa-times"></i>
            </button>

            <h2>New Category</h2>
            <p class="error"></p>

            <form action="controllers/editCategoryController.php" method="post" onsubmit="return false">
                <p class="formInput">
                    <input type="text" name="categoryName" id="categoryName_add">
                    <label for="categoryName_add">Category Name</label>
                </p>

                <div class="modalButtons">
                    <button class="linkButton" id="add">Add New</button>
                    <button class="linkButton close">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <div class="editModal modal <?= isset($editCategory) ? "active" : null ?>">
        <div class="modalBody">
            <button class="closeConfirmation close">
                <i class="fas fa-times"></i>
            </button>

            <h2>Edit Category</h2>
            <p class="error"></p>
            
            <form action="controllers/editCategoryController.php" method="post" onsubmit="return false">
                <p class="formInput">
                    <input type="text" id="categoryName_edit" name="categoryName" value="<?= isset($editCategory) ? $editCategory->CategoryName : null ?>">
                    <label for="categoryName_edit">Category Name</label>
                </p>
            </form>

            <div class="modalButtons">
                <button class="linkButton" id="edit">Edit</button>
                <button class="linkButton close">Cancel</button>
            </div>
        </div>
    </div>

    
</section>