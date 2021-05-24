$("#changePassword").click(event=>{
    event.preventDefault();
    
    let valid = true;

    let fields = document.querySelectorAll(".formInput input")
    
    for (const field of fields) {
        if(field.value.trim() == ""){
            $(field).siblings(".inputErrors")[0].innerHTML = "- Field must contain a value";
            valid = false;
        }
    }

    if(fields[0].value === fields[1].value){
        $(fields[1]).siblings(".inputErrors")[0].innerHTML = "- New password is the same as old one";
        valid = false;
    }

    if(fields[1].value !== fields[2].value){
        $(fields[2]).siblings(".inputErrors")[0].innerHTML = "- New passwords don't match";
        valid = false;
    }

    if(!valid) return false;

    $("form").submit();
})

$("#cancel").click(event=>{
    event.preventDefault();
    window.location.href = "./index.php";
})