import {AJAXRequest} from "./modules/AJAX.js";

$("#addToCart").submit(function(event) {
    event.preventDefault();

    let url = $(this).attr("action");
    let formData = new FormData(this);
    formData.append("cartMethod", "Add");

    if(formData.get("quantity") > 25 || formData.get("quantity") <= 0) return alert("Quantity out of range. Please enter a quantity between 1 and 25");

    AJAXRequest(url, formData).then((returnData)=>{
        if(returnData.success){
            let shoppingCart = document.querySelector(".cartTotal");
            shoppingCart.innerHTML = returnData.data.CartItems;

            ToggleModal();
        }
    })
});

$(".cartModal .closeConfirmation").click(function(){
    ToggleModal();
});

function ToggleModal(){
    let modal = document.querySelector(".cartModal");
    modal.classList.toggle("active");
}
