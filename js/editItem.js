$(document).ready(function(){
    window.ItemTable = $("#items").DataTable({
        responsive: true,
        ajax: "controllers/editItemController.php",
        columns: [
            {"data": "ItemID"},
            {"data": "ItemName"},
            {"data": "Photo"},
            {"data": "Price"},
            {"data": "SalePrice"},
            {"data": "Description"},
            {"data": "Featured"},
            {"data": "Category.CategoryName"}
        ],
        scrollX: true
    });
});

$("#items tbody").on("click", "tr", function(event){
    let contextMenu = document.querySelector(".contextMenu");
    contextMenu.classList.add("active");

    let rowDetails = [];
    $(event.target).parent().children().each(function(){
        rowDetails.push(this.innerText);
    })

    let hiddenFields = document.querySelectorAll(".contextMenu input[type='hidden']");
    for(let i = 0; i < hiddenFields.length; i++){
        hiddenFields[i].value = rowDetails[i];
    }

    let rowPos = event.target.getBoundingClientRect();
    let midwayPoint = rowPos.y + window.scrollY + rowPos.height / 2;

    posX = event.pageX + 24 + "px";
    posY = midwayPoint - 24 + "px";

    contextMenu.style.left = posX;
    contextMenu.style.top = posY;
    
}).on("dblclick", "tr", function(){
    alert("Test");
})