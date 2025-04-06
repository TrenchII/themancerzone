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
    let passwordsMatch = true;
    // Validate passwords match
    let passwordsArr = Array.from(passwords);
    let [pass1, pass2] = passwordsArr;
    if (pass1.value !== pass2.value) {
        // do something
        removeText(pass1);
        removeText(pass2);
        alterText(pass1, "Passwords do not match!")
        alterText(pass2, "Passwords do not match!")
        validSubmission = false;
        passwordsMatch = false;
    }


    // Validate if required fields are filled in
    formRequiredElements.forEach(el => {
        if (el.value.length == 0 || (el.type == "password" && passwordsMatch && el.value.length == 0)) {
            removeText(el);
            // do something
            alterText(el, "This field is required!");
            validSubmission = false;
        }
        if (el.name == "img" && el.files[0].size > 2097152) {
            removeText(el);
            // do something
            alterText(el, "File is too large, limit it to below 2MB");
            validSubmission = false;
        }        
        emailregex = /^[^@]+@[^@]+\.[^@]+$/;
        if(el.name == 'email' && !(el.value.match(emailregex))){
            removeText(el);
            // do something
            alterText(el, "Please input a properly formatted email!");
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

submit.addEventListener("click", submitHandler);

function changeHandler(e) {
    removeText(this);
}

formRequiredElements.forEach((el) => {
    el.addEventListener("focus", changeHandler);
})