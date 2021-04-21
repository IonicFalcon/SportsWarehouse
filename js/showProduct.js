$("#addToCart").submit(function(event) {
    event.preventDefault();

    let url = $(this).attr("action");
    let formData = new FormData(this);
    formData.append("cartMethod", "Add");

    if(formData.get("quantity") > 25 || formData.get("quantity") <= 0) return alert("Quantity out of range. Please enter a quantity between 1 and 25");

    console.log(formData.get("quantity"));

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
