function joinRoom() {
    const username = document.getElementById('username').value;
    const roomName = document.getElementById('input_room').value;
    socket.emit('joinRoom', {
        "username": username,
        "room": roomName
    });
}

function renderNewMessage(message) {
    const newMessage = document.getElementById("new-message");
    newMessage.innerHTML += message
    newMessage.innerHTML += `<br>---------------------------------------------------------------------------------`

    /* Scroll Down */
    shouldScroll = newMessage.scrollTop + newMessage.clientHeight === newMessage.scrollHeight;
    // After getting your messages.
    if (!shouldScroll) {
        scrollToBottom();
    }
}

function scrollToBottom() {
    const newMessage = document.getElementById("new-message");
    newMessage.scrollTop = newMessage.scrollHeight;
}

scrollToBottom();