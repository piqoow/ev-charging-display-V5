var socket = io.connect('111.0.201.52 :7081');

socket.on('connect', function () {
    // const wsstatus = document.getElementById("ws-status");
    // wsstatus.innerHTML = `Web Socket Server are Connected.`
    console.log("connect to server");
});

socket.on("disconnect", () => {
    // const wsstatus = document.getElementById("ws-status");
    // wsstatus.innerHTML = `<p style="color: red">Web Socket Server are Disconnected. Reconnect again...</p>`
    console.log("Dissconnect from server");
});

// Message from server
socket.on('message', (message) => {
    // renderNewMessage(`New Message on ${message.time}`)
});

// Update LOT on a Floor
socket.on('update-lot', (message) => {
    console.log("update lot")
    const data = message.data
    var capacity  = document.getElementById("capacity");
    var available = document.getElementById("available");
    var used      = document.getElementById("used");
    var val_used  = 0;
    
    capacity.innerHTML  = `${data.capacity}`;
    available.innerHTML = `${data.available}`;
    val_used            = `${data.capacity-data.available}`;

    const ve = (val_used < 0) ? 0 : val_used;
    used.innerHTML = ve;  

});

// Message from server
socket.on('seq-num', (message) => {
    renderNewMessage(`New Message on ${message.time}`)
});

(function() {
    // var objDiv = document.getElementById("new-message");
    // objDiv.scrollTop = objDiv.scrollHeight;
    const username = display_code;
    const roomName = room;
    socket.emit('joinRoom', {
        "username": username,
        "room": roomName
    });
 })();