import {AJAXRequest} from "./modules/AJAX.js";

// Controls the togglable form sections
$(".collapsible").click(function (){
    let header = this;
    let form = $(header).siblings()[0];

    header.classList.toggle("collapsed");
    form.classList.toggle("collapsed");
})

// Validate Shipping info form then goto payment form
$("#gotoPayment").click(function (){
    if(!ShippingInfoValidation()) return false;

    let shippingHeader = $(this).parents().siblings()[3];
    let paymentHeader = document.querySelector(".paymentDetails > h2");

    shippingHeader.click();
    paymentHeader.click();

    let creditCardInput = document.querySelector("#creditCard");
    creditCardInput.focus();
});

// Submit shipping form as an AJAX request, then submit the payment info synchronously 
$("#placeOrder").click(function(){
    if(!ShippingInfoValidation() || !PaymentInfoValidation()) return false;

    let shippingInfo = new FormData(document.querySelector("#shippingInfo"));
    shippingInfo.append("AJAXHalf", true);

    let url = $("#shippingInfo").attr("action");

    AJAXRequest(url, shippingInfo).then(()=>{
        let paymentInfo = document.querySelector("#paymentInfo");
        paymentInfo.submit();
    });
})


function ShippingInfoValidation(){
    let inputFields = document.querySelectorAll("#shippingInfo input");
    let invalidFields = [];

    for(let field of inputFields){
        $(field).siblings()[1].innerText = "";

        if(field.value === null || field.value.trim() === ""){
            let errorField = [
                field, 
                "- Field must contain a value.\n"
            ];

            invalidFields.push(errorField);
        }   
    }

    if(invalidFields.length === 0){
        return true;
    } else{
        for(let error of invalidFields){
            $(error[0]).siblings()[1].innerText = error[1];
        }

        return false;
    }
}


function PaymentInfoValidation(){
    let inputFields = document.querySelectorAll("#paymentInfo input");
    let invalidFields = [];

    for(let field of inputFields){
        $(field).siblings()[1].innerText = "";

        if(field.value === null || field.value.trim() === ""){
            let errorField = [
                field, 
                "- Field must contain a value"
            ];

            invalidFields.push(errorField);
        }   
    }

    let creditCard = inputFields[0];
    if(!ValidateCreditCard(creditCard.value)){
        let errorField = [
            creditCard,
            "- Credit card is invalid"
        ]

        invalidFields.push(errorField);
    }

    let expiryMonth = inputFields[1];
    let expiryYear = inputFields[2];

    if(expiryMonth.value < 0 || expiryMonth.value > 12){
        let errorField = [
            expiryMonth,
            "- Invalid Month"
        ];
        invalidFields.push(errorField);
    }

    if(parseInt(expiryYear.value) < parseInt(new Date().getFullYear().toString().substr(-2))){
        let errorField = [
            expiryYear,
            "- Card has expired"
        ]

        invalidFields.push(errorField);
    }

    if(parseInt(expiryMonth.value) < new Date().getMonth + 1 && parseInt(expiryYear.value) == parseInt(new Date().getFullYear().toString().substr(-2))){
        let errorField = [
            expiryMonth,
            "- Card has expired"
        ]

        invalidFields.push(errorField);
    }

    let CVV = inputFields[3];

    if(CVV.value.length != 3){
        let errorField = [
            CVV,
            "- Invalid CVV"
        ]

        invalidFields.push(errorField);
    }

    if(invalidFields.length === 0){
        return true;
    } else{
        for(let error of invalidFields){
            $(error[0]).siblings()[1].innerText = error[1];
        }

        return false;
    }


}

function ValidateCreditCard(number){
    //Luhn Algorithm used for validating credit cards
    if(number.length != 16) return false;

    let numbers = number.split("");
    let sum = 0;

    for(let i = 0; i < numbers.length; i ++){
        if(i % 2 === 0){
            numbers[i] *= 2;
            
            if(numbers[i] > 9){
                numbers[i] -= 9;
            }
        }

        sum += parseInt(numbers[i]);
    }

    return (sum % 10) == 0;
}