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
</section>