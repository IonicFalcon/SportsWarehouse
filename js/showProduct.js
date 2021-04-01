import {SubmitAJAXRequest} from "./modules/AJAX.js";

$("#addToCart").submit(function(event) {
    event.preventDefault();

    let url = $(this).attr("action");
    let formData = new FormData(this);

    let returnData = SubmitAJAXRequest(url, formData);
    let shoppingCart = document.querySelector(".cartTotal");

    shoppingCart.innerText = returnData.CartItems;
})

$(document).ready(()=>{
    if(screen.width >= 450){
        let zoomOptions = {
            width: 500,
            zoomWidth: 1000,
            zoomContainer: document.querySelector(".zoomContainer"),
            zoomStyle: "z-index: 2;position: absolute;"
        };

        new ImageZoom(document.querySelector(".zoomContainer"), zoomOptions);
    }
})