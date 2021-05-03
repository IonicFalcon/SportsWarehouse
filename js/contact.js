function ContactFormValidation(){
    let requiredFields = document.querySelectorAll(".contactUs *[required]");
    let invalidFields = [];

    for(let field of requiredFields){
        if(field.value === null || field.value.trim() === ""){
            let errorField = [
                field,
                "- Field must contain a value\n"
            ];

            invalidFields.push(errorField)
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