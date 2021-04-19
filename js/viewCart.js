$(".itemQuantity").change(function(event){
    let itemData = {
        quantity: $(this).val(),
        itemName: $(this).parent().siblings()[0].innerText,
        cartMethod: "Edit"
    }
    
    //AJAX request via JQuery seem to only like FormData objects.....
    let formData = new FormData();

    for(let key in itemData){
        formData.append(key, itemData[key]);
    }
    
    $.ajax({
        type: "POST",
        url: "controllers/shoppingCartController.php",
        data: formData,
        success: (returnData) => {
            returnData = JSON.parse(returnData);

            let shoppingCartButton = document.querySelector(".cartTotal");
            shoppingCartButton.innerHTML = returnData.CartItems;

            let cartSubtotal = document.querySelector(".subtotal").lastElementChild;
            cartSubtotal.innerHTML = `$${returnData.CartSubtotal}`;

            let cartDiscount = document.querySelector(".discount").lastElementChild;
            cartDiscount.innerHTML = `-$${returnData.CartDiscount}`;

            let cartTotal = document.querySelector(".totalPrice").lastElementChild;
            cartTotal.innerHTML = `$${returnData.CartTotal}`;

            let itemSubtotal = $(this).parent().siblings()[2];
            itemSubtotal.innerHTML = `$${returnData.ItemSubtotal}`;


        },
        datatype: "json",
        processData: false,
        contentType: false
    })
});

$(".removeItem").click(function(event){
    let itemData = {
        itemName: $(this).parent().siblings().children()[0].innerText,
        cartMethod: "Delete"
    }

    let formData = new FormData();

    for(let key in itemData){
        formData.append(key, itemData[key]);
    }

    $.ajax({
        type: "POST",
        url: "controllers/shoppingCartController.php",
        data: formData,
        success: (returnData) => {
            returnData = JSON.parse(returnData);

            let shoppingCartButton = document.querySelector(".cartTotal");
            shoppingCartButton.innerHTML = returnData.CartItems;

            let cartSubtotal = document.querySelector(".subtotal").lastElementChild;
            cartSubtotal.innerHTML = `$${returnData.CartSubtotal}`;

            let cartDiscount = document.querySelector(".discount").lastElementChild;
            cartDiscount.innerHTML = `-$${returnData.CartDiscount}`;

            let cartTotal = document.querySelector(".totalPrice").lastElementChild;
            cartTotal.innerHTML = `$${returnData.CartTotal}`;
            
            $(this).parents()[1].remove();
        },
        datatype: "json",
        processData: false,
        contentType: false
    })
});