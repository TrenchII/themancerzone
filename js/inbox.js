let messages = document.getElementById('messages');
function refresh() {
    fetch("/themancerzone/php/inbox.php").then(res => {
        return res.json();
    }).then(data => {
      messages.innerHTML = '';
      data.forEach((k)=>{messageDisplay(Object.entries(k))});
    });
}

setInterval(refresh, 5000);
refresh();

function messageDisplay(data) {
  let sUserName = data[0][1];
  let message = data[1][1];
  let date = data[2][1];
  let messageContainer = document.createElement("div");
  messageContainer.className = 'messagecontainer';
  
  let sender = document.createElement("p");
  sender.innerHTML="<a href='/themancerzone/profile.php?username=" + sUserName +"'><span style='font-weight: bold;'>From: </span>" +sUserName+"</a>";

  let messageText = document.createElement("p");
  messageText.style = "font-style: italic";
  messageText.innerHTML = message;

  let dateText = document.createElement("p");
  dateText.style = "color:#ada99b; font-style: italic;";
  dateText.innerHTML = date;

  messageContainer.appendChild(sender);
  messageContainer.appendChild(messageText);
  messageContainer.appendChild(dateText);
  messages.appendChild(messageContainer);
}