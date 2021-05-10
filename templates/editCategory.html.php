<section class="editCategory">
    <table id="categories" class="stripe hover row-border cell-border">
        <thead>
            <tr>
                <th>Category ID</th>
                <th>Category Name</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($categories as $category){
                    ?>
                        <tr>
                            <td class="id"><?= $category->CategoryID ?></td>
                            <td><?= $category->CategoryName ?></td>
                        </tr>
                    <?php
                }
            ?>
        </tbody>
    </table>

    <nav class="contextMenu">
        <ul>
            <li><a href="#" class="iconButton edit">Edit Category</a></li>
            <li><a href="#" class="iconButton delete">Delete Category</a></li>
        </ul>
        <input type="hidden" id="rowID">
        <input type="hidden" id="rowName">
    </nav>

    <div class="editModal modal">
        <div class="modalBody">
            <button class="closeConfirmation close">
                <i class="fas fa-times"></i>
            </button>

            <h2>Edit Category</h2>
            <form action="controllers/editCategoryController.php" method="post">
                <p class="formInput">
                    <input type="text" id="categoryName" name="categoryName">
                    <label for="categoryName">Category Name</label>
                </p>
            </form>

            <div class="modalButtons">
                <button class="linkButton" id="edit">Edit</button>
                <button class="linkButton close">Cancel</button>
            </div>
        </div>
    </div>
</section>