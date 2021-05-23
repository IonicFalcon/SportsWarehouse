import {AJAXRequest} from "./modules/AJAX.js";

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

    let posX = event.pageX + 24 + "px";
    let posY = midwayPoint - 24 + "px";

    contextMenu.style.left = posX;
    contextMenu.style.top = posY;
    
})

$(".contextMenu .add.iconButton").click(event=>{
    event.preventDefault();

    let addModal = document.querySelector(".addModal");

    addModal.classList.add("active");
    document.querySelector(".root").classList.add("modalOpen");

    let modalBody = document.querySelector(".addModal .modalBody");

    if(modalBody.getBoundingClientRect().top < 0) addModal.classList.add("overflow");
})

$(".contextMenu .edit.iconButton").click(event=>{
    event.preventDefault();

    let editModal = document.querySelector(".editModal");
    
    editModal.classList.add("active")
    document.querySelector(".root").classList.add("modalOpen");

    let modalBody = editModal.querySelector(".modalBody");

    if(modalBody.getBoundingClientRect().top < 0) editModal.classList.add("overflow");

    let hiddenFields = document.querySelectorAll('nav.contextMenu input[type="hidden"]');

    document.querySelector("#itemName_edit").value = hiddenFields[1].value;

    if(hiddenFields[2].value != "") {
        document.querySelector(".editModal .itemPhoto").src = "images/productImages/" + hiddenFields[2].value;
    } else{
        document.querySelector(".editModal .itemPhoto").src = "images/productImages/placeholder.png";
    }

    document.querySelector("#itemPrice_edit").value = hiddenFields[3].value;
    document.querySelector("#itemOnSale_edit").checked = hiddenFields[4].value != "";
    document.querySelector("#itemSalePrice_edit").value = hiddenFields[4].value ?? null;
    document.querySelector("#itemDescription_edit").innerText = hiddenFields[5].value ?? null;
    document.querySelector("#itemFeatured_edit").checked = hiddenFields[6].value == 1;

    let categorySelection = document.querySelector("#itemCategory_edit");
    for(let [i, option] of [...categorySelection.options].entries()){
        if(option.innerText == hiddenFields[7].value){
            categorySelection.selectedIndex = i;
            break;
        }
    }
})

$(".modal .close").click(event=>{
    event.preventDefault();

    let imagePreview = document.querySelector(".modal.active .itemPhoto");
    imagePreview.src = "images/productImages/placeholder.png";

    $(event.target).parents(".modal")[0].classList.remove("active");
    document.querySelector(".root").classList.remove("modalOpen");
});

$('.modalBody form input[type="file"]').change(event=>{
    let imagePreview = $(event.target).parent().siblings("img.itemPhoto")[0];
    let image = event.target.files[0];

    const validImageTypes = ["images/gif", "image/jpeg", "image/png"];

    if(image && validImageTypes.includes(image["type"])){
        imagePreview.src = URL.createObjectURL(image);
    }
})

$("#itemOnSale_add, #itemOnSale_edit").change(event=>{
    let saleInput = $(event.target).parent().siblings().children("input")[0];

    if(event.target.checked){
        $(saleInput).prop("disabled", false);
    } else{
        saleInput.value = "";
        $(saleInput).prop("disabled", true);
    }
})

$("#add").click(event=>{
    event.preventDefault();

    let form = $(event.target).parents("form")[0];
    if (!ValidateForm(form)) return false;

    document.querySelectorAll(".modal.active .inputErrors").forEach(element=>{
        element.value = "";
    })


    let url = form.action;
    let formData = new FormData(form);
    formData.append("method", "Add");

    SubmitRequest(url, formData);
})

$("#edit").click(event=>{
    event.preventDefault();

    let form = $(event.target).parents("form")[0];
    if(!ValidateForm(form)) return false;

    let url = form.action;
    let formData = new FormData(form);
    formData.append("itemID", document.querySelector("#rowID").value)
    formData.append("method", "Edit");

    SubmitRequest(url, formData);
})

function SubmitRequest(url, data){
    AJAXRequest(url, data).then(returnedData=>{
        console.log(returnedData);

        if(returnedData.success){
            window.ItemTable.ajax.reload();
            $(".modal.active .close").click();
        } else{
            document.querySelector(".modal.active .error").innerText = returnedData.data;
        }
    })
}

function ValidateForm(form){
    let formInputs = form.querySelectorAll(".formInput > *:first-child:required");
    let invalidFields = [];

    for(let field of formInputs){
        if(field.value.trim() === ""){
            let errorField = [
                field,
                "- Field must contain a value"
            ];

            invalidFields.push(errorField);
        }
    }

    let imageInput = formInputs[1];
    const validImageTypes = ["images/gif", "image/jpeg", "image/png"];

    if(imageInput.files && !validImageType.include(imageInput.files[0].type)){
        let errorField = [
            imageInput,
            "- File is not an image"
        ];

        invalidFields.push(errorField);
    }

    let moneyFields = form.querySelectorAll("input.money");
    for (let money of moneyFields) {
        if($(money).parents("fieldset")[0]){
            if (money.disabled) continue;
        }

        if(parseFloat(money.value) == NaN){
            console.log(money)
            let errorField = [
                money,
                "- Value is not a number"
            ];

            invalidFields.push(errorField);
        }
    }
    
    let saleCheckbox = $(moneyFields[1]).parent().siblings().children(`input[type="checkbox"]`)[0];

    if(saleCheckbox.checked){
        if (moneyFields[1].value > moneyFields[0].value){
            let errorField = [
                moneyFields[1],
                "- Sale price can't be more than regular price"
            ]
    
            invalidFields.push(errorField);
        }
    
        if (moneyFields[1].value == 0){
            let errorField = [
                moneyFields[1],
                "- Sale price can't be $0.00"
            ]
    
            invalidFields.push(errorField);
        }
    }

    if(invalidFields.length === 0){
        return true;
    } else{
        for(let error of invalidFields){
            $(error[0]).siblings(".inputErrors")[0].innerText = error[1];
        }

        return false;
    }
}