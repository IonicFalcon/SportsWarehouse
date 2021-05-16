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
}).click(function(event){
    let rows = document.querySelectorAll("#items td");
    rows = Array.prototype.slice.call(rows);

    let contextMenu = document.querySelector(".contextMenu");

    if(!rows.includes(event.target)) contextMenu.classList.remove("active");
})

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

$(".contextMenu .add.iconButton").click(event=>{
    event.preventDefault();

    let addModal = document.querySelector(".addModal");

    addModal.classList.add("active");
    document.querySelector(".root").classList.add("modalOpen");

    let modalBody = document.querySelector(".addModal .modalBody");

    if(modalBody.getBoundingClientRect().top < 0) addModal.classList.add("overflow");
})

$(".modal .close").click(event=>{
    event.preventDefault();

    $(event.target).parents(".modal")[0].classList.remove("active");
    document.querySelector(".root").classList.remove("modalOpen");
});

$("#itemOnSale_add, #itemOnSale_edit").change(event=>{
    console.log(event);
    let saleInput = $(event.target).parent().siblings().children("input")[0];

    if(event.target.checked){
        $(saleInput).prop("disabled", false);
    } else{
        saleInput.value = "";
        $(saleInput).prop("disabled", true);
    }
})