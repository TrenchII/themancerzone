const form = document.getElementById("form");
const requiredData = document.querySelectorAll("[required]");
const resetInput = document.querySelector(".reset");
const submit = document.querySelector(".submit");

function removeText(divElement) {
    if(divElement.length == undefined || divElement.length == null || divElement.className == "select") {
        if (divElement.nextSibling != null) {
            divElement.nextSibling.remove()
            divElement.removeAttribute("id");
        }
    }
    else {
        for (let i =0; i <divElement.length;i++) {
            if (divElement[i].nextSibling != null) {
                divElement[i].nextSibling.remove()
                divElement[i].removeAttribute("id");
            }
        }
    }

}

function submitHandler(e) {
    let allFilled = true;
    for (let i = 0; i < requiredData.length; i++) {
        console.log(requiredData[i]);
        let formData = requiredData[i].value;
        removeText(requiredData[i]);
        if(formData.length == null || formData.length == "") {
            allFilled = false;

            let parent = requiredData[i].parentNode;
            let text = document.createTextNode("This field is required");
            let div = document.createElement("div");

            div.appendChild(text);
            div.setAttribute("class","errorDiv failed");
            parent.appendChild(div);

            requiredData[i].setAttribute("id","failed");
        }
    }
    if(!allFilled) {
        e.preventDefault();
    }
}

submit.addEventListener("click",submitHandler)

function changeHandler(e) {
    removeText(this);
}

for (let i =0; i <requiredData.length;i++) {
    requiredData[i].addEventListener("focus",changeHandler); 
}
