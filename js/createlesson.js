let form = document.getElementById("form");
let formRequiredElements = document.querySelectorAll('input[required]')
let submit = document.querySelector(".submit");
const resetInput = document.querySelector(".reset");


function removeText(divElement) {
    if (divElement.length == undefined || divElement.length == null || divElement.className == "select") {
        if (divElement.nextSibling != null) {
            divElement.nextSibling.remove()
            divElement.removeAttribute("id");
        }
    }
    else {
        for (let i = 0; i < divElement.length; i++) {
            if (divElement[i].nextSibling != null) {
                divElement[i].nextSibling.remove()
                divElement[i].removeAttribute("id");
            }
        }
    }

}

function submitHandler(e) {
    let validSubmission = true;
    let date;
    let time;
    // Validate if required fields are filled in
    formRequiredElements.forEach(el => {
        if (el.value.length == 0 && el.name != "img") {
            removeText(el);
            // do something
            alterText(el, "This field is required!");
            validSubmission = false;
        }
        else if (el.name == "img" && el.files[0].size > 2097152) {
            removeText(el);
            // do something
            alterText(el, "File is too large, limit it to below 2MB");
            validSubmission = false;
        }
        else if (el.name == "img" && el.value.length == 0 ) {
            removeText(el);
            // do something
            alterText(el, "");
            validSubmission = false;
        }
        else if(el.name=='datetime') {
            if(!(el.checkValidity())) {
                removeText(el);
            // do something
            alterText(el, "Incorrect Date! Please choose a date in the future!");
            validSubmission = false;
            }
        }
    })
    if(!validSubmission) {
        e.preventDefault();
    }
}

function alterText(field, errorText) {
    let parent = field.parentElement;
    let div = document.createElement('div');
    div.textContent = errorText;

    div.classList.add('errorDiv', 'failed');
    parent.appendChild(div);

    field.id = "failed";
}

submit.addEventListener("click", submitHandler)

function changeHandler(e) {
    removeText(this);
}

formRequiredElements.forEach((el) => {
    el.addEventListener("focus", changeHandler);
})