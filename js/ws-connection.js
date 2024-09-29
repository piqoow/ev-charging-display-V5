var socket = io.connect('staging.centrepark.co.id:7081');

socket.on('connect', function () {
    // console.log("connect to server");
    joinRoom()
});

socket.on("disconnect", () => {
    // console.log("Dissconnect from server");
});

// Test on Update Data
socket.on('update-lot', (message) => {
    var button_status = (message.data.ev_status.status == 'ON') ? `<button type="button" class="custom-btn btn-disable-2" id="btn_start" disabled></button>` : `<button type="button" class="custom-btn btn-2" onclick="myFunction()" id="btn_start"></button>`;
    console.log(message.data.ev_status.status);
    // if(floor == message.data.floor_code){
    //     const data = message.data
    //     $('#available-space').html(data.available);
    //     $('#capacity-space').html(data.capacity);
    //     $('#occupied-space').html(data.used);
    // }
});

const joinRoom = () => {
    // // console.log("Try to join room")
    // const username = floor;
    // const roomName = room;
    // // console.log(room)
    // socket.emit('joinRoom', {
    //     "username": username,
    //     "room": roomName
    // });
}