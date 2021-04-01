export function SubmitAJAXRequest(url, data){
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: (returnData) =>{
            return JSON.parse(returnData);
        },
        datatype: "json",
        processData: false,
        contentType: false
    })
}