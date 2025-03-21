const chits = document.getElementsByClassName("chit-btn");
function toggleHandler(e) {
    let currentChit = this;
    let currentChitID = this.id;
    console.log(currentChitID);
    let chitCheckbox = document.querySelector('input[id=' + currentChitID + ']');
    console.log(chitCheckbox);
    let chitcolor = currentChit.classList.contains('chitlight');
    if(chitcolor) {
        chitCheckbox.checked = true;
    }
    else {
        chitCheckbox.checked = false;
    }
    currentChit.classList.toggle("chitlight",!chitcolor);
    currentChit.classList.toggle("chitdark",chitcolor);
    e.preventDefault();
}

for(let i = 0; i < chits.length; i++) {
    chits[i].addEventListener('click',toggleHandler);
}