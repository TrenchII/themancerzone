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
        if (el.value.length == 0) {
            removeText(el);
            // do something
            alterText(el, "This field is required!");
            validSubmission = false;
        }
        
        dateregex = /\d{1,2}\/\d{1,2}\/\d{2,4}/;
        timeregex = /^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/;
        if(el.name == "date" && !(dateregex.test(el.value))) {
            removeText(el);
            // do something
            alterText(el, "Incorrect date format! Should be DD/MM/YY");
            validSubmission = false;
        }
        else if (el.name == "date") {
            date = el;
        }
        if(el.name=="time" && !(timeregex.test(el.value))) {
            removeText(el);
            // do something
            alterText(el, "Incorrect time format! Should be DD/MM/YY");
            validSubmission = false;
        }
        else if(el.name=="time") {
            time = el;
        }
    })
    datetime = new Date(date.value + " " + time.value +":00");
    if(datetime < Date.now()){
        removeText(date);
        removeText(time);
        // do something
        alterText(date, "Date in the past! Please choose a future date!");
        alterText(time, "Date in the past! Please choose a future date!");
        validSubmission = false;
    }
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