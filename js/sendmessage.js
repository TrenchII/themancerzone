let form = document.getElementById("form");
let formRequiredElements = document.querySelectorAll('input[required]')
let passwords = Array.from(document.querySelectorAll('input[type="password"]'));
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

    // Validate if required fields are filled in
    formRequiredElements.forEach(el => {
        if (el.value.length == 0) {
            removeText(el);
            // do something
            alterText(el, "This field is required!");
            validSubmission = false;
        }
    })
    if (!validSubmission) {
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