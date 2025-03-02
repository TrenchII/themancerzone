const chits = document.getElementsByClassName("chit-btn");
function toggleHandler(e) {
    let currentChit = this;
    let chitcolor = currentChit.classList.contains('chitlight');
    currentChit.classList.toggle("chitlight",!chitcolor);
    currentChit.classList.toggle("chitdark",chitcolor);
    e.preventDefault();
}

for(let i = 0; i < chits.length; i++) {
    chits[i].addEventListener('click',toggleHandler);
}