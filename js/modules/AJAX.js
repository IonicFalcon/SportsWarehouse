/**
 * Submit an AJAX request to server and return data
 * 
 * @param {string} url 
 * @param {object} data
 * @returns {object} returnData
 */
export async function AJAXRequest(url, data){
    let returnData;

    await $.ajax({
        url: url,
        type: "POST",
        data: data,
        processData: !(data instanceof FormData),
        contentType: data instanceof FormData ? false : "application/x-www-form-urlencoded; charset=UTF-8"
    }).done(data=>{
        //What needs to be done with the returned data is different for every request, so just parse the returned JSON
        returnData = {
            data: JSON.parse(data),
            success: true
        }
    }).fail(xhr=>{
        //A Failed Request tends to be handled the same way everytime on each page, so some of the instructions can be put here
        let data = JSON.parse(xhr.responseText);
        let errorMessage;

        //Server errors are out of user's control. Log error in console and display generic message
        if(xhr.status == 500){
            errorMessage = "A server error has occured. Sorry for the inconvience.";
            console.error(data.error);
        } 
        //Client errors are the user's fault. Display appropriate error message
        else{
            errorMessage = data.error;
        }

        returnData = {
            data: errorMessage,
            success: false
        }
    });

    return returnData;
}