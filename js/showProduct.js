$("#addToCart").submit(function(event) {
    event.preventDefault();

    let url = $(this).attr("action");
    let formData = new FormData(this);

    $.ajax({
        type: "POST",
        url: url,
        data: formData,
        success: (returnData) =>{
            alert("Added Item to Shopping Cart!");
            let shoppingCart = document.querySelector(".cartTotal");
            shoppingCart.innerText = returnData.ShoppingCartLength;  
        },
        datatype: "json",
        processData: false,
        contentType: false
    })
})