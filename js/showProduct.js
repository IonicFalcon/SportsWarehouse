$("#addToCart").submit(function(event) {
    event.preventDefault();

    let url = $(this).attr("action");
    let formData = new FormData(this);
    formData.append("cartMethod", "Add");

    $.ajax({
        type: "POST",
        url: url,
        data: formData,
        success: (returnData) =>{
            returnData = JSON.parse(returnData);
            
            let shoppingCart = document.querySelector(".cartTotal");
            shoppingCart.innerHTML = returnData.CartItems;

            ToggleModal();
        },
        datatype: "json",
        processData: false,
        contentType: false
    });
});

$(".cartModal .closeConfirmation").click(function(){
    ToggleModal();
});

function ToggleModal(){
    let modal = document.querySelector(".cartModal");
    modal.classList.toggle("hidden");
}
