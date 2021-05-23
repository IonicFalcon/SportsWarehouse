import {AJAXRequest} from "./modules/AJAX.min.js";

$(".itemQuantity").change(function(event){
    let itemData = {
        quantity: $(this).val(),
        itemName: $(this).parent().siblings()[0].innerText,
        cartMethod: "Edit"
    }

    if(itemData.quantity > 25 || itemData.quantity <= 0) return alert("Quantity out of range. Please enter a quantity between 1 and 25");

    AJAXRequest("controllers/shoppingCartController.php", itemData).then(returnData=>{
        if(returnData.success){
            FillData(returnData.data);

            let itemSubtotal = $(this).parent().siblings()[2];
            itemSubtotal.innerHTML = `$${returnData.data.ItemSubtotal}`;
        }
    })
});

$(".removeItem").click(function(event){
    let itemData = {
        itemName: $(this).parent().siblings().children()[0].innerText,
        cartMethod: "Delete"
    }

    AJAXRequest("controllers/shoppingCartController.php", itemData).then(returnData=>{
        if(returnData.success){
            FillData(returnData.data);

            $(this).parents()[1].remove();
        }
    })
});

function FillData(data){
    let shoppingCartButton = document.querySelector(".cartTotal");
    shoppingCartButton.innerHTML = data.CartItems;

    let cartSubtotal = document.querySelector(".subtotal").lastElementChild;
    cartSubtotal.innerHTML = `$${data.CartSubtotal}`;

    let cartDiscount = document.querySelector(".discount").lastElementChild;
    cartDiscount.innerHTML = `-$${data.CartDiscount}`;

    let cartTotal = document.querySelector(".totalPrice").lastElementChild;
    cartTotal.innerHTML = `$${data.CartTotal}`;
}