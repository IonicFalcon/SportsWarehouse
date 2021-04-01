$("#addToCart").submit(function(event) {
    event.preventDefault();

    let url = $(this).attr("action");
    let formData = new FormData(this);

    $.ajax({
        type: "POST",
        url: url,
        data: formData,
        success: (returnData) =>{
            returnData = JSON.parse(returnData);
            
            let shoppingCart = document.querySelector(".cartTotal");
            shoppingCart.innerHTML = returnData.CartItems;
        },
        datatype: "json",
        processData: false,
        contentType: false
    });
});
