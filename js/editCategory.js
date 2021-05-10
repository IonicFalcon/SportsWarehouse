$(document).ready(function(){
    window.CategoryTable = $("#categories").DataTable({
        responsive: true,
        ajax: "controllers/editCategoryController.php",
        columns: [
            {"data": "CategoryID"},
            {"data": "CategoryName"}
        ]
    });
})

$(document).click(function(event){
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

$(".contextMenu .edit.iconButton").click((event) =>{
    event.preventDefault();

    document.querySelector(".editModal").classList.add("active");
    document.querySelector(".root").classList.add("modalOpen");

    let categoryName = document.querySelector("#categoryName");
    categoryName.value = document.querySelector("#rowName").value;
});

$(".modal .close").click(event =>{
    event.preventDefault();

    $(event.target).parents(".modal")[0].classList.remove("active");
    document.querySelector(".root").classList.remove("modalOpen");
})

$("#edit").click(event =>{
    event.preventDefault();

    let url = $(".editModal form").attr("action");

    let data = {
        categoryID: document.querySelector("#rowID").value,
        categoryName:  document.querySelector("#categoryName").value,
        method: "Edit"
    };

    $.ajax({
        type: "POST",
        url: url,
        data: data
    }).done(()=>{
        window.CategoryTable.ajax.reload();
        $(".modal .close").click();
        
    }).fail((xhr, status, error) =>{
        console.log();
    })
});

function getMousePosition(e){
    return{
        x: e.pageX,
        y: e.pageY
    };

}