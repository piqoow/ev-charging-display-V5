<?php

DEFINE("root", "http://" . htmlspecialchars($_SERVER["HTTP_HOST"]) . "/ev-charging-display-V5/");
//GET FLOOR DATA & DEFINE ON JAVASCRIPT VARIABLE
$id = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

echo '<script> var id = "' . $id . '";</script>';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="./images/logo-cp.png" />
    <title>Ev Charging</title>
    <link rel="stylesheet" href="./public/css/potrait-v2-wsdelta.css" />
</head>

<body>
    <div class="container" id="slide">
    <img src="images/bg-idle.png" alt="" style="display: block; margin-left:23.0%; margin-top:-21.7%;"/>
        <!-- Charging Page -->
        <div class="header" id="chargingpage" style="display: block;">
            <button class="custom-btn btn-7"><span id="status_btn">StandBy ...</span></button>
            <div class="charging-block" id="chargingblock">
                <img src="./images/car-eve.png" alt="this slowpoke moves" width="150px" height="120px" id="img-top" style="display: block; margin-left:-20px; margin-top:20px;" />
            </div>

            <div style="display: block;"></div>
            <div class="description-line">
                <div class="time-line" id="time-line" style="display: block;">
                    <div class="charge-font desc-font" style="margin-top: 5px;" id="time">00:00:00</div>
                </div>
                <div class="energy-line" id="energy-line" style="display: block;">
                    <div class="charge-font desc-font" id="kwh">0.00 kWh</div>
                </div>
                <div class="power-line" id="power-line" style="display: block;">
                    <div class="charge-font desc-font" id="power">0 kw</div>
                </div>
            </div>

            <!-- Full Charging Page -->

        </div>
        <div class="header" id="fullpage" style="display:none;">
            <button class="custom-btn btn-7"><span style="margin-top: 15px;">Finish Charging..</span></button>

            <div class="full-space" id="">
                <table>
                    <tbody id="dataTab">

                    </tbody>
                </table>
            </div>
        </div>

</body>
<script src="./public/vendor/jquery-3.6.0/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    var status = '';
    var energy = 0;
    var power = 0;
    var date = '';
    var volt = 0;
    var arus = 0;
    var id_ev = 0;
    var loopingId = 0;
    var insert_status = '';
    var code = '';
    var voucher = 0;
    var usage_status = '';
    var usage_date = '';
    // var ev_id = '';

    // mendapatkan ip address di database
    <?php
    include 'db/connection.php';
    $id = $_GET['id'];
    $db = new DB();
    $stmt = $db->pdo->prepare("SELECT ip_address FROM evgate WHERE customer_id = '$id'");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $ip_address = $result['ip_address'];
    ?>
    const ws = new WebSocket("ws://" + "<?php echo $ip_address; ?>" + ":3001/websocket");

    // const ws = new WebSocket("ws://10.15.34.35:3001/websocket");
    // const ws = new WebSocket("wss://cp-websocket.stroomer.co.id?customerid=SM413e46eb377918&dashboard=true");
    
    // Refresh page ketika WebSocket error
        ws.onerror = function(error) {
        console.error("WebSocket error:", error);
        location.reload(true);
    };
    
ws.addEventListener("open", () => {
    console.log(ws);
});

    ws.onmessage = function(event) {
        console.log('Received message:', event.data);
        // Lakukan sesuatu dengan pesan yang diterima dari server
        // Reset timeout setiap kali menerima pesan
        console.log("TIMEOUT");
        resetTimeout();
    };

    ws.onclose = function(event) {
        console.log('WebSocket connection closed with code:', event.code, 'Reason:', event.reason);
        // Coba untuk melakukan koneksi ulang setelah jeda tertentu
        // setTimeout(connectWebSocket, 3000); // Contoh: coba koneksi ulang setelah 3 detik
        resetTimeout();
    };

//WS REALTIME
    let updateEvgateCalled = false;
    let flagStopwatch = false;
    var startTime = 0;
    var elapsedTime = 0;
    var timeoutId = null;
    var power_countdown = 0;
    const TIMEOUT_DURATION = 10000; // 10 detik
    let timeoutIdd;

    ws.addEventListener("message", (e) => {
    const data = JSON.parse(e.data);
    function secondsToHHMMSS(seconds) {
    const hours = Math.floor(seconds / 3600);
    const minutes = Math.floor((seconds % 3600) / 60);
    const remainingSeconds = seconds % 60;

    const formattedHours = hours.toString().padStart(2, '0');
    const formattedMinutes = minutes.toString().padStart(2, '0');
    const formattedSeconds = remainingSeconds.toString().padStart(2, '0');

    return `${formattedHours}:${formattedMinutes}:${formattedSeconds}`;
}

var chargingTimeInSeconds = Number(data['charging-time']);
var formattedChargingTime = secondsToHHMMSS(chargingTimeInSeconds);
console.log(formattedChargingTime);

    // console.log(Number(data.signal));
    console.log(data.voltage);
    console.log(data['charging-state']);

    //WS 30S
        // console.log(Number(data.signal));

        var current = data.current;
        // var roundedCurrent = totalCurrent.toFixed(2);
        var voltage1 = Number(data.voltage);
        var voltage2 = Number(data.voltage2);
        var voltage3 = Number(data.voltage3);
        var voltage = data.voltage + data.voltage2 + data.voltage3;
        var numberOfValues = 3;
        var averageVoltage = integerValue / numberOfValues;
        var integerValue = Math.floor(voltage) / 3;
        var chargedEnergy = Number(data['charged-energy']);
        var chargerStatus = (data['charger-status']);
        var inpower = Number(data['power']);
        var fixedinpower = Math.floor(inpower)/1000;
        var fixedroundedinpower = fixedinpower.toFixed(1);

        console.log(fixedroundedinpower);
        console.log(chargerStatus);
        var roundedEnergy = Math.floor(chargedEnergy)/1000;
        var fixedRoundedEnergy = roundedEnergy.toFixed(1);
        // var roundedEnergy = Number(data.energy.toFixed(2));
        console.log(current);
        // console.log(integerValue);
        // console.log(data.roundedEnergy);
        
        // var roundedEnergyString = data.energy.toFixed(2);
        // var roundedEnergyNumber = parseFloat(roundedEnergyString);
        // console.log(roundedEnergyNumber); // Output: 4.99


if (data['charger-status'] === 'Charging') { // 2 > kondisi charging
    stopParkeeService();
    $('#status_btn').html(`Charging ${data.voltage} Volt..`);
    $('#kwh').html(fixedRoundedEnergy + ' kWh');
    $('#power').html(` ${fixedroundedinpower} kw`);
    $('#time').html(`${formattedChargingTime}`);
    $('.header').removeClass('.header').addClass('header-run');
    flagStopwatch = true;
    startStopwatch();
//    insertDelta();
    updateEvgate(chargerStatus, current, data.voltage, data.power, fixedRoundedEnergy);
    updateEvgateCalled = true;
} else if (data['charger-status'] === 'Preparing' || data['charger-status'] === 'Available' && updateEvgateCalled === true) { //3 > kondisi setelah charging ke standby dalam kondisi mesin ev masih nyala
    insertDelta();
    $('#status_btn').html('Charging Ready...');
    $('#kwh').html('0.00 kWh');
    //$('#time').html(`${formattedChargingTime}`);
    $('#time').html('00:00:00');
    $('#power').html('0 kw');
    $('.header').removeClass('.header-run').addClass('header');
    flagStopwatch = false;
    if (updateEvgateCalled === true) { // pada saat kondisi charging ke standby akan update dan insert data charging 
        // insertDelta();
    startParkeeService();
        document.getElementById('fullpage').style.display = 'block';
        document.getElementById('chargingpage').style.display = 'none';
        get_data_logcharging();
        $('#status_btn').html(`Finish Charging...`);
        $('.header').removeClass('header-run').addClass('.header')
//        loopingId++;
//            console.log("Timeout");
//            if (loopingId > 10) {
//                loopingId = 0;
//                updateEvgateCalled = true;
//            }
    setTimeout(function() {
        get_data_logcharging();
    console.log("delay 15 seconds");
    }, 10000);
	updateEvgateCalled = false;
    }
} else if (data['charger-status'] === 'SuspendedEV' || data['charger-status'] === 'Unavailable' && updateEvgateCalled === true) { //kondisi setelah charging ke standby dalam kondisi mesin ev mati
    insertDelta();
    $('#status_btn').html('Charging ...');
    $('#time').html('00:00:00');
//    $('#time').html(`${formattedChargingTime}`);
    $('#kwh').html('0.00 kWh');
    $('#power').html('0 kw');
    $('.header').removeClass('.header-run').addClass('header');
    flagStopwatch = false;
    if (updateEvgateCalled === true) { // pada saat kondisi charging ke standby akan update dan insert data charging 
        // insertDelta();
        startParkeeService();
        document.getElementById('fullpage').style.display = 'block';
        document.getElementById('chargingpage').style.display = 'none';
        get_data_logcharging();
        $('#status_btn').html(`Finish Charging...`);
        $('.header').removeClass('header-run').addClass('.header')
//        loopingId++;
//            console.log("Timeout");
//            if (loopingId > 10) {
//                loopingId = 0;
//                updateEvgateCalled = true;
//            }
    setTimeout(function() {
        get_data_logcharging();
    console.log("delay 15 seconds");
    }, 10000);
	updateEvgateCalled = false;
    }
} else if (data['charger-status'] === 'Preparing' || data['charger-status'] === 'Available' && updateEvgateCalled === false) { // kondisi charging ready
    $('#status_btn').html('Charging Ready...');
    $('#kwh').html('0.00 kWh');
    $('#time').html('00:00:00');
//    $('#time').html(`${formattedChargingTime}`);
    $('#power').html('0 kw');
    $('.header').removeClass('.header-run').addClass('header');
    flagStopwatch = false;
    document.getElementById('fullpage').style.display = 'none';
    updateEvgate(chargerStatus, current, data.voltage, data.power, fixedRoundedEnergy);
    document.getElementById('chargingpage').style.display = 'block';
    elapsedTime = 0;
    startTime = Date.now();
    // clearTimeout(timeoutid);
    displayTime(0, 0, 0, 0);
} else if (data['charger-status'] === 'Unavailable' && updateEvgateCalled === false) {  // 1 > kondisi standby false atau kondisi standby inisiasi pertama
    // Handle other statuses
    $('#status_btn').html(`StandBy ...`);
    $('#kwh').html( `0.00 kWh`);
    $('#time').html('00:00:00');
//    $('#time').html(`${formattedChargingTime}`);
    $('#power').html('0 kw');
    $('.header').removeClass('.header-run').addClass('header');
    updateEvgate(chargerStatus, current, data.voltage, data.power, fixedRoundedEnergy);
    //refresh the page at 23:59:59
    refreshAt(23,59,59);
    // Only call updateEvgate if not already called 
    // updateEvgateCalled = true;
} else {
    $('#status_btn').html(`StandBy ...`);
    $('#kwh').html( `0.00 kWh`);
    $('#time').html('00:00:00');
//    $('#time').html(`${formattedChargingTime}`);
    $('#power').html('0 kw');
    $('.header').removeClass('.header-run').addClass('header');
    flagStopwatch = false;
    //refresh the page at 23:59:59
    refreshAt(23,59,59);
    document.getElementById('fullpage').style.display = 'none';
    document.getElementById('chargingpage').style.display = 'block';
    }

// Handle the default case
// if (data.status === 'standby') {
//     $('#status_btn').html('StandBy ...');
//     $('#kwh').html('0.00 kWh');
//     $('#power').html('0 A');
// }
});

function resetTimeout() {
    // Hapus timeout sebelumnya (jika ada)
    clearTimeout(timeoutIdd);
    // Atur timeout baru
    timeoutIdd = setTimeout(handleTimeout, TIMEOUT_DURATION);
}

function handleTimeout() {
    console.log('No message received within the timeout period.');
    // Tindakan yang diambil ketika tidak ada pesan yang diterima dalam jangka waktu tertentu
    // Contoh: mencoba untuk melakukan koneksi ulang
    location.reload(true);
}

function stopParkeeService() {
        $.ajax({
            type: "POST",
            url: "api/stop-parkee-ev-service.php",
            data: {
                id: id
            },
            success: function(response) {
                console.log(response);
            },
            error: function(error) {
                console.error("AJAX request failed:", error);
            }
        });
    }
 
    function startParkeeService() {
        $.ajax({
            type: "POST",
            url: "api/start-parkee-ev-service.php",
            data: {
                id: id
            },
            success: function(response) {
                console.log(response);
            },
            error: function(error) {
                console.error("AJAX request failed:", error);
            }
        });
    }

function refreshAt(hours, minutes, seconds) {
    var now = new Date();
    var then = new Date();

    if(now.getHours() > hours ||
        (now.getHours() == hours && now.getMinutes() > minutes) ||
        now.getHours() == hours && now.getMinutes() == minutes && now.getSeconds() >= seconds) {
        then.setDate(now.getDate() + 1);
    }
    then.setHours(hours);
    then.setMinutes(minutes);
    then.setSeconds(seconds);

    var timeout = (then.getTime() - now.getTime());
    setTimeout(function() { window.location.reload(true); }, timeout);
}

function insertDelta() {
        var time = document.getElementById('time').innerHTML;
    $.ajax({
        type: "POST",
        url: "api/selecttoinsert.php",
        data: {
                id: id,
                // kwh: kwh,
                time: time
            },
        success: function(response) {
            console.log(response);
        },
        error: function(error) {
            console.error("AJAX request failed:", error);
        }
    });
}

function get_data_log_Delta() {
    $.ajax({
        type: "POST",
        url: "api/initialize-potrait.php",
        success: function(response) {
            console.log(response);
        },
        error: function(error) {
            console.error("AJAX request failed:", error);
        }
    });
}

function updateEvgate(chargerStatus, current, voltage, power, fixedRoundedEnergy) {
    // Calculate the average voltage and round to the nearest whole number
    // var roundedAverageVoltage = Math.round((voltage + voltage2 + voltage3) / 3);
    // var roundedCurrent = Math.round(current + current2 + current3);
    var time = document.getElementById('time').innerHTML;
    $.ajax({
        type: "POST",
        url: "api/insert-delta.php", // Replace with the actual path
        data: {
            id: id,
            chargerStatus: chargerStatus,
            voltage: voltage,
            current: current,
            power: power,
            fixedRoundedEnergy: fixedRoundedEnergy,
            time: time
        },
        async: true,
        dataType: "JSON",
        success: function (response) {
            console.log("Signal updated successfully");
            // Handle the response if needed
        },
        error: function (error) {
            console.error("Error updating signal", error);
            // Handle the error if needed
        }
    });
}

    $(document).ready(function() {
        get_data_charging();
    })

    var startTime = 0;
    var elapsedTime = 0;
    var timeoutId = null;
    var power_countdown = 0;

    startTime = Date.now();
    myTimer = setInterval(function() {
        clearInterval(myTimer)
        elapsedTime += Date.now() - startTime;
        clearTimeout(timeoutId);
    }, 1000);

    // function get_data_charging() {
    //     var ev_id = id;
    //     $.ajax({
    //         type: 'POST',
    //         url: "<?= root ?>api/data-potrait.php",
    //         async: true,
    //         dataType: 'JSON',
    //         data: {
    //             ev_id: ev_id,
    //         },
    //         success: function(r) {
    //             //success(r);
    //             var data = r.ev_status;
    //             status = data.status;
    //             volt = data.voltase;
    //             energy = data.energy;
    //             power = data.power;
    //             arus = data.arus;
    //             id_ev = data.ev_id;
    //             inserts = data.inserts;
    //             voucher = data.voucher;
    //             usage_status = data.usage_status;
    //             usage_date = data.usage_date;
    //             code = data.status_code;


    //             if (status == 'ON' && arus <= 0.2) {
    //                 //ON BUT NO INPUT ARUS
    //                 if (inserts == 0 && code == 0) {
    //                     loopingId++;
    //                     console.log("Timeout");
    //                     if (loopingId > 60) {
    //                         loopingId = 0;
    //                         updateStatus();
    //                     }
    //                     $('#status_btn').html('Charging Ready...');
    //                     $('#kwh').html(`0.00 kWh`);
    //                     $('#power').html(`0 A`);
    //                     document.getElementById('fullpage').style.display = 'none';
    //                     document.getElementById('chargingpage').style.display = 'block';
    //                     // updateData();

    //                     $('.bar-battery-1').removeClass('charge1')
    //                     $('.bar-battery-2').removeClass('charge2')
    //                     $('.bar-battery-3').removeClass('charge3')
    //                     $('.bar-battery-4').removeClass('charge4')
    //                     $('.desc-font').removeClass('full-font').addClass('charge-font')
    //                     $('#loading').removeClass('loading').addClass('loading-off');


    //                     $('#chargingblock').html(`<img src="./images/car-eve.png" alt="this slowpoke moves" width="170px" height="170px" style="margin-top:-35px; margin-left:-20px;" />`);
    //                     elapsedTime = 0;
    //                     startTime = Date.now();
    //                     clearTimeout(timeoutId);
    //                     displayTime(0, 0, 0, 0);
    //                 } else if (inserts == 1 && code == 0 && arus <= 0.2) {
    //                     loopingId++;
    //                     console.log("Loading to Finish");
    //                     if (loopingId > 5) {
    //                         loopingId = 0;
    //                         insertData();
    //                         updateData2();
    //                     }
    //                     $('#status_btn').html(`Charging ${volt} Volt..`);
    //                     $('#kwh').html(`${energy} kWh`);
    //                     $('#power').html(`${arus} A`)
    //                     document.getElementById('fullpage').style.display = 'none';
    //                     document.getElementById('chargingpage').style.display = 'block';
    //                     // updateData();
    //                     $('.bar-battery-1').removeClass('charge1-2').addClass('charge1')
    //                     $('.bar-battery-2').removeClass('charge2-2').addClass('charge2')
    //                     $('.bar-battery-3').removeClass('charge3-2').addClass('charge3')
    //                     $('.bar-battery-4').removeClass('charge4-2').addClass('charge4')
    //                     $('.desc-font').removeClass('full-font').addClass('charge-font')
    //                     $('#loading').removeClass('loading-off').addClass('loading');
    //                     $('#chargingblock').html(`<img src="./images/car-eve.png" alt="this slowpoke moves" width="170px" height="170px" style="margin-top:-35px; margin-left:-20px;"/>`);
    //                     startStopwatch();
    //                 } else if (inserts == 1 && code == 1) {
    //                     loopingId++;
    //                     console.log("Finish");
    //                     if (loopingId > 60) {
    //                         loopingId = 0;
    //                         updateStatus();
    //                     }
    //                     $('#status_btn').html(`Finish Charging...`);
    //                     get_data_logcharging();
    //                     // updateData2();
    //                     document.getElementById('fullpage').style.display = 'block';
    //                     document.getElementById('chargingpage').style.display = 'none';
    //                     $('.header').removeClass('header-run').addClass('.header')


    //                 }
    //             } else if (status == 'ON' && arus >= 0.2) { //ON AND ARUS 1
    //                 $('#status_btn').html(`Charging ${volt} Volt..`);
    //                 $('#kwh').html(`${energy} kWh`);
    //                 $('#power').html(`${arus} A`)
    //                 document.getElementById('fullpage').style.display = 'none';
    //                 document.getElementById('chargingpage').style.display = 'block';

    //                 updateData();
    //                 $('.bar-battery-1').removeClass('charge1-2').addClass('charge1')
    //                 $('.bar-battery-2').removeClass('charge2-2').addClass('charge2')
    //                 $('.bar-battery-3').removeClass('charge3-2').addClass('charge3')
    //                 $('.bar-battery-4').removeClass('charge4-2').addClass('charge4')
    //                 $('.desc-font').removeClass('full-font').addClass('charge-font')
    //                 $('.header').removeClass('.header').addClass('header-run')

    //                 $('#chargingblock').html(`<img src="./images/car-eve.png" alt="this slowpoke moves" width="170px" height="170px" style="margin-top:-35px; margin-left:-20px;"/>`);
    //                 startStopwatch();
    //             } else {
    //                 $('#status_btn').html('StandBy...');
    //                 $('#kwh').html(`0.00 kWh`);
    //                 $('#power').html(`0 A`)
    //                 document.getElementById('fullpage').style.display = 'none';
    //                 document.getElementById('chargingpage').style.display = 'block';
    //                 if (code != 0) { //Kondisi Idle apabila stuck code 1 akan update menjadi 0
    //                     updateStatus();
    //                 }
    //                 $('.bar-battery-1').removeClass('charge1')
    //                 $('.bar-battery-2').removeClass('charge2')
    //                 $('.bar-battery-3').removeClass('charge3')
    //                 $('.bar-battery-4').removeClass('charge4')
    //                 $('.desc-font').removeClass('full-font').addClass('charge-font')
    //                 $('#loading').removeClass('loading').addClass('loading-off');

    //                 //console.log(data);

    //                 if (usage_status == 'Belum Terpakai') {
    //                     loopingId++;
    //                     console.log("Barcode");
    //                     if (loopingId > 60) {
    //                         loopingId = 0;
    //                         updateVoucher();
    //                     }
    //                     $('#chargingblock').html(`<div class="charge-font desc-font" style="margin-left: -8px; margin-top: 30px; font-size: 30px"> You Code is <br> ${voucher}</div>`);
    //                     //console.log(0);
    //                 } else {
    //                     //console.log(0)

    //                     $('#chargingblock').html(`<img src="./images/QREXPO.jpeg" alt="this slowpoke moves" width="133px" height="133px" />`);
    //                     console.log(1);
    //                 }
    //                 elapsedTime = 0;
    //                 startTime = Date.now();
    //                 clearTimeout(timeoutId);
    //                 displayTime(0, 0, 0, 0);
    //             }
    //         },
    //         complete: function() {
    //             setTimeout(function() {
    //                 get_data_charging();
    //             }, 1000);
    //         },

    //     })

    //     // return result
    // }

    function get_data_logcharging() {
        //var ev_id = id;
        $.ajax({
            url: "<?= root ?>api/initialize-potrait.php",
            data: {
                id: id
            },
            type: "POST",
            dataType: "json",
            success: function(r) {
                var data = r[0];
                energy = data.energy;
                var newEnergy = data.energy;
                time = data.timenow;
                date = data.tanggal;
                var splitdate = date.split(' ');
                var datesplit = splitdate[0];
                var timesplit = splitdate[1];
                var html = '';

                html += `<tr>
                            <td class="legend-saldo">Duration</td>
                            <td class="legend-saldo">:</td>
                            <td class="legend-saldo">${time}</td>
                        </tr>
                        <tr>
                            <td class="legend-saldo">Energy</td>
                            <td class="legend-saldo">:</td>
                            <td class="legend-saldo">${newEnergy}</td>
                        </tr>
                        <tr>
                            <td class="legend-saldo">Date</td>
                            <td class="legend-saldo">:</td>
                            <td class="legend-saldo">${datesplit}</td>
                        </tr>`;

                $('#dataTab').html(html);
            },
            complete: function() {
                setTimeout(function() {
                    get_data_logcharging();
                }, 1000);
            },
        })
    }

    function startStopwatch() {
        //run setTimeout() and save id
        if (flagStopwatch) {
                timeoutId = setTimeout(function() {
                //calculate elapsed time
                const time = Date.now() - startTime + elapsedTime;

                //calculate different time measurements based on elapsed time
                const seconds = parseInt((time / 1000) % 60)
                const minutes = parseInt((time / (1000 * 60)) % 60)
                const hour = parseInt((time / (1000 * 60 * 60)) % 24);

                //display time
                displayTime(hour, minutes, seconds);

                //calling same method again recursivaly
                startStopwatch();
            }, 100);
        }  
    }

    function displayTime(hour, minutes, seconds) {
        if (hour == 0 && minutes == 0 && seconds ==0) {
            flagStopwatch = false;
        } else {
            var stopwatch = document.getElementById('time');
            hour = hour < 10 ? '0' + hour : hour;
            minutes = minutes < 10 ? '0' + minutes : minutes;
            seconds = seconds < 10 ? '0' + seconds : seconds;
            stopwatch.innerHTML = hour + ':' + minutes + ':' + seconds;
        }
        
    }

    function insertData() {
        //var mainButton  = document.getElementById('btn_start');
        var ev_id = id;
        var kwh = document.getElementById('kwh').innerHTML;
        var time = document.getElementById('time').innerHTML;
        //var status = 0;
        $.ajax({
            type: "POST",
            url: "<?= root ?>api/log_insert-potrait.php",
            data: {
                ev_id: id,
                kwh: kwh,
                time: time
            },
            async: true,
            dataType: "JSON",
            success: function(r) {
                $('#mode').text('Standby...');
                $('#kwh').html(`0.00 kWh`);
                $('#power').html(`0 A`);
            }
        })
    }

    var viewFullScreen = document.getElementById("slide");
    if (viewFullScreen) {
        viewFullScreen.addEventListener("click", function() {
            var docElm = document.documentElement;
            if (docElm.requestFullscreen) {
                docElm.requestFullscreen();
            } else if (docElm.msRequestFullscreen) {
                docElm.msRequestFullscreen();
            } else if (docElm.mozRequestFullScreen) {
                docElm.mozRequestFullScreen();
            } else if (docElm.webkitRequestFullScreen) {
                docElm.webkitRequestFullScreen();
            }
        })
    }

    function updateData() {
        $.ajax({
            type: "POST",
            url: "<?= root ?>api/update_log.php",
            data: {
                id: id
            },
            async: true,
            dataType: "JSON",
            success: function(r) {
                console.log('Update Insert 1');
            }
        })
    }

    function updateDataO() {
        $.ajax({
            type: "POST",
            url: "<?= root ?>api/update_log_0.php",
            data: {
                id: id
            },
            async: true,
            dataType: "JSON",
            success: function(r) {
                console.log('Update Insert 0');
            }
        })
    }

    function updateData2() {
        $.ajax({
            type: "POST",
            url: "<?= root ?>api/update_statuscode.php",
            data: {
                id: id
            },
            async: true,
            dataType: "JSON",
            success: function(r) {
                //insertData();
                console.log('Update Status Code 1');
            }
        })
    }

    function updateStatus() {
        $.ajax({
            type: "POST",
            url: "<?= root ?>api/update_status.php",
            data: {
                id: id
            },
            async: true,
            dataType: "JSON",
            success: function(r) {
                console.log('Update Status OFF');
            }
        })
    }

    function updateVoucher() {
        $.ajax({
            type: "POST",
            url: "<?= root ?>api/update_voucher.php",
            data: {
                id: id
            },
            async: true,
            dataType: "JSON",
            success: function(r) {
                console.log('Update Voucher Terpakai');
            }
        })
    }
</script>

</html>
