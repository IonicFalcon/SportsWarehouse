import {AJAXRequest} from "./modules/AJAX.min.js";

$(document).ready(function(){
    window.CategoryTable = $("#categories").DataTable({
        responsive: true,
        ajax: "controllers/editCategoryController.php",
        columns: [
            {"data": "CategoryID"},
            {"data": "CategoryName"}
        ]
    });
}).click(function(event){
    let rows = document.querySelectorAll("#categories td");
    rows = Array.prototype.slice.call(rows);

    let contextMenu = document.querySelector(".contextMenu");

    //Close context menu if a row wasn't clicked on
    if(!rows.includes(event.target)) contextMenu.classList.remove("active");
})

$("#categories tbody").on("click", "tr", function(event){
    //Show the context menu
    let contextMenu = document.querySelector(".contextMenu");
    contextMenu.classList.add("active");

    //Push all row values to an array
    let rowDetails = [];
    $(event.target).parent().children().each(function(){
        rowDetails.push(this.innerText)
    });

    //Assign hidden fields row values
    let hiddenFields = document.querySelectorAll(".contextMenu input[type='hidden']");
    for(let i = 0; i < hiddenFields.length; i++){
        hiddenFields[i].value = rowDetails[i];
    }

    //Get the mid point of the row
    let rowPos = event.target.getBoundingClientRect();
    let midwayPoint = rowPos.y  + window.scrollY + rowPos.height / 2;

    //Position menu so that arrow points to midway point
    let posX = event.pageX + 24 + "px";
    let posY = midwayPoint - 24 + "px";

    contextMenu.style.left = posX;
    contextMenu.style.top = posY;
    
}).on("dblclick", "tr", function (){
    alert("Test");
});

$(".contextMenu .add.iconButton").click(event =>{
    event.preventDefault();

    document.querySelector(".addModal").classList.add("active");
    document.querySelector(".root").classList.add("modalOpen");
})

$(".contextMenu .edit.iconButton").click(event =>{
    event.preventDefault();

    document.querySelector(".editModal").classList.add("active");
    document.querySelector(".root").classList.add("modalOpen");

    let categoryName = document.querySelector("#categoryName_edit");
    categoryName.value = document.querySelector("#rowName").value;
});

$(".contextMenu .delete.iconButton").click(event =>{
    event.preventDefault();

    document.querySelector(".deleteModal").classList.add("active");
    document.querySelector(".root").classList.add("modalOpen");
})

$(".modal .close").click(event =>{
    event.preventDefault();

    $(event.target).parents(".modal")[0].classList.remove("active");
    document.querySelector(".root").classList.remove("modalOpen");
})

$("#add").click(event=>{
    event.preventDefault();

    let value = document.querySelector("#categoryName_add").value;
    if(value.trim().length == 0) return false;

    let url = $(".addModal form").attr("action");

    let data = {
        categoryName: value,
        method: "Add"
    };

    SubmitRequest(url, data);
})

$("#edit").click(event =>{
    event.preventDefault();
    
    let originalValue = document.querySelector("#rowName").value;
    let newValue = document.querySelector("#categoryName_edit").value;

    if(newValue === originalValue) return false;
    if(newValue.trim().length == 0) return false;

    let url = $(".editModal form").attr("action");

    let data = {
        categoryID: document.querySelector("#rowID").value,
        categoryName:  newValue,
        method: "Edit"
    };

    SubmitRequest(url, data);
});

$("#delete").click(event=>{
    event.preventDefault();

    let url = $(".deleteModal form").attr("action");

    let data = {
        categoryID: document.querySelector("#rowID").value,
        method: "Delete"
    };

    SubmitRequest(url, data);
})

//Deals with what to do for an AJAX request on this page (formatting data)
function SubmitRequest(url, data){
    //As AJAXRequest is an asynchronous function, the .then() interface is used to deal with the returned Promise
    AJAXRequest(url, data).then(returnedData=>{
        if(returnedData.success){
            updateCategories(returnedData.data);

            window.CategoryTable.ajax.reload();
            $(".modal.active .close").click();
        } else{
            document.querySelector(".modal.active .error").innerText = returnedData.data;
        }
    })
}

function updateCategories(data){
    let categoryLinks = document.querySelectorAll("nav.categoryNav > ul");

    for(const linkSection of categoryLinks) {
       $(linkSection).empty();

       for (const category of data) {
           $(linkSection).append(`<li><a href="searchProducts.php?cat=${category.CategoryID}">${category.CategoryName}</a></li>`);
       }

    }
}