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
    posX = event.pageX + 24 + "px";
    posY = midwayPoint - 24 + "px";

    contextMenu.style.left = posX;
    contextMenu.style.top = posY;
});

$("#categories tbody").on("dblclick", "tr", function (){
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

    AJAXRequest(url, data);
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

    AJAXRequest(url, data);
});

$("#delete").click(event=>{
    event.preventDefault();

    let url = $(".deleteModal form").attr("action");

    let data = {
        categoryID: document.querySelector("#rowID").value,
        method: "Delete"
    };

    AJAXRequest(url, data);
})

function AJAXRequest(url, data){
    $.ajax({
        type: "POST",
        url: url,
        data: data
    }).done(data=>{
        data = JSON.parse(data);

        updateCategories(data);

        window.CategoryTable.ajax.reload();
        $(".modal.active .close").click();
    }).fail(xhr =>{
        let data = JSON.parse(xhr.responseText);
        let errorMessage;

        //Server errors are out of user's control. Log error in console and display generic message
        if(xhr.status == 500){
            errorMessage = "A server error has occured. Sorry for the inconvience.";
            console.error(data.error);
        } 
        //Client errors are the user's fault. Display appropriate error message
        else{
            errorMessage = data.error;
        }

        document.querySelector(".modal.active .error").innerText = errorMessage;
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