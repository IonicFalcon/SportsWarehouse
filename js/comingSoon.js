/**
 * Validates form for valid data
 * @returns {boolean} Form Valid
 */
function ValidateForm(){
    var errorList = [];

    var form = document.forms["feedback"];
    //Required fields here, as required attribute could be removed by user
    var requiredFields = [
        "firstName",
        "lastName",
        "email",
        "question"
    ];

    for(var field of requiredFields){
        var requiredField = form[field];

        //Check if value is null or whitespace
        if(!requiredField.value || requiredField.value.match(/^\s*$/)){
            var label = requiredField.labels[0];
            //Push the label of the field to the error list
            errorList.push(label)
        }
    }

    //If email isn't missing
    if(!errorList.includes("email")){
        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        //If email isn't valid, push label to error list
        if(!emailRegex.test(form["email"])){
            let label = form["email"].labels[0];
            errorList.push(label);
        }
    }

    if (errorList.length > 0){
        //Apply error class for styling to all error labels
        for(var label of errorList){
            label.classList.add("error");
        }

        var errorMessage = document.querySelector("#errorMessage");
        errorMessage.innerText = "Please check the marked fields."

        return false;
    }

    return true;
}

/** 
 * Reset all fields to a blank state
*/
function ResetForm(){
    var form = document.forms["feedback"];

    for(var element of form){
        //Skip over the buttons and fieldset
        if (element.parentElement.classList.contains("formButtons")) continue;
        if (element.nodeName == "FIELDSET") continue;
        //Reset field to blank and remove error class from label
        element.value = "";
        element.labels[0].classList.remove("error");

        //Reset error message
        var errorMessage = document.querySelector("#errorMessage");
        errorMessage.innerText = "";
    }
}