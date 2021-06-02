function ContactFormValidation(){
    let formFields = document.querySelectorAll(".contactUs input, .contactUs textarea");
    let invalidFields = [];

    for(let field of formFields){
        if(field.hasAttribute("required")){
            if(field.value === null || field.value.trim() === ""){
                let errorField = [
                    field,
                    "- Field must contain a value\n"
                ];
    
                invalidFields.push(errorField)
            }
        }
    }

    let firstName = formFields[0];
    if(firstName.value.trim().length < 2){
        let errorField = [
            firstName,
            "- Field must be at least 2 characters long"
        ];

        invalidFields.push(errorField);
    }

    let lastName = formFields[1];
    if(lastName.value.trim().length < 2){
        let errorField = [
            lastName,
            "- Field must be at least 2 characters long"
        ];

        invalidFields.push(errorField);
    }

    const phoneRegex = /^((000|112|106)|((\+61[- ]??|\(?0)[−]?[23478]?([- ]?\d){8})|((13|180)([- ]?\d){4})|((1300|1800|190\d)([- ]?\d){6}))$/;
    let contactNumber = formFields[2];
    
    if(!phoneRegex.test(contactNumber.value)){
        let errorField = [
            contactNumber,
            "- Contact number must be a valid Australian phone number"
        ];

        invalidFields.push(errorField);
    }

    const emailRegex = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
    let email = formFields[3];
    if(!emailRegex.test(email.value)){
        let errorField = [
            email,
            "- Email must be in a valid format"
        ];

        invalidFields.push(errorField);
    }

    let question = formFields[4];
    if(question.value.trim().length < 30){
        let errorField = [
            question,
            "- Question must be at least 30 characters long"
        ];

        invalidFields.push(errorField);
    }

    formFields.forEach(field=>{
        $(field).siblings()[1].innerText = "";
    })

    if(invalidFields.length === 0){
        return true;
    } else{
        for(let error of invalidFields){
            $(error[0]).siblings()[1].innerText = error[1];
        }

        return false;
    }
}

$(".contactUs button[type='submit']").click(function (event){
    event.preventDefault();

    if(ContactFormValidation()){
        let form = document.querySelector(".contactUs form");
        form.submit();
    } else{
        return false;
    }
})

$(".contactUs button[type='reset']").click(function (event){
    event.preventDefault();

    let fields = document.querySelectorAll(".contactUs input, .contactUs textarea");

    for(let field of fields){
        field.value = "";
        
        $(field).siblings()[1].innerText = "";
        $(field).siblings()[0].classList.remove("error");
    }
})