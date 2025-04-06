let firstRun = true;
let lastCount = -1;
function refresh() {
    fetch("php/messagecount.php").then(res => {
        return res.json();
    }).then(data => {
      data.forEach((k)=>{messageDisplay(k)});
    }).catch(err => {

    });
}

setInterval(refresh, 5000);
refresh();

function messageDisplay(data) {
  let messagecount = data[0];
  if(firstRun) {
    firstRun = false;
    lastcount = messagecount;
  }
  else if(messagecount > lastcount) {
    let diff = messagecount - lastcount;
    lastcount = messagecount;
    alert("You have " + diff + " new messages!");
  }
}