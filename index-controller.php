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
    <link rel="icon" href="./images/logo-cp.png"/>
    <title>EV Charging</title>
    <link rel="stylesheet" href="./public/css/potrait-v2.css" />
</head>

<body>
    <div class="container" id="slide">
    <!-- <img src="images/bg-idle.png" alt="" /> -->
        <!-- Charging Page -->
        <div class="header" id="chargingpage" style="display: block;">
        
            <!-- <video class="header-ads" autoplay loop muted>
                <source src="./public/BECALL.mp4" type="video/mp4">
            </video> -->
        

            <button class="custom-btn btn-7"><span id="status_btn"></span></button>
            <div class="charging-block" id="chargingblock">
                <img src="./images/car-eve.png" alt="this slowpoke moves" width="170px" id="img-top" />
            </div>

            <div style="display: block;"></div>
            <div class="description-line">
                <div class="time-line" id="time-line" style="display: block;">
                    <div class="charge-font desc-font" style="margin-top: 5px;" id="time">00:00:00</div>
                </div>
                <div class="energy-line" id="energy-line" style="display: block;">
                    <div class="charge-font desc-font" id="kwh"></div>
                </div>
                <div class="power-line" id="power-line" style="display: block;">
                    <div class="charge-font desc-font" id="power"></div>
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
        <!-- ADS CONTENT -->
        <!-- <div class="content">
            <video style="position:absolute; margin-top:0%; margin-left:-40%; height:650; width:160%;" loop muted autoplay>
                <source src="public/BECALL.mp4" type="video/mp4">
            </video>
        </div> -->
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

    function get_data_charging() {
        var ev_id = id;
        $.ajax({
            type: 'POST',
            url: "<?= root ?>api/data-potrait.php",
            async: true,
            dataType: 'JSON',
            data: {
                ev_id: ev_id,
            },
            success: function(r) {
                //success(r);
                var data = r.ev_status;
                status = data.status;
                volt = data.voltase;
                energy = data.energy;
                power = data.power;
                arus = data.arus;
                id_ev = data.ev_id;
                inserts = data.inserts;
                voucher = data.voucher;
                usage_status = data.usage_status;
                usage_date = data.usage_date;
                code = data.status_code;


                if (status == 'ON' && arus <= 0.2) {
                    //ON BUT NO INPUT ARUS
                    if (inserts == 0 && code == 0) {
                        loopingId++;
                        console.log("Timeout");
                        if (loopingId > 15) {
                            loopingId = 0;
                            updateStatus();
                        }
                        $('#status_btn').html('Charging Ready...');
                        $('#kwh').html(`0.00 kWh`);
                        $('#power').html(`0 A`);
                        document.getElementById('fullpage').style.display = 'none';
                        document.getElementById('chargingpage').style.display = 'block';
                        $('.header').removeClass('header-ads').addClass('header');//ubah
                        $('.description-line').removeClass('description-line-hide').addClass('.description-line');//ubah
                        $('.charging-block').removeClass('charging-block-hide').addClass('.charging-block');//ubah
                        $('.custom-btn').removeClass('custom-btn-hide').addClass('.custom-btn');//ubah
    // updateData();
                        $('#chargingblock').html(`<img src="./images/car-eve.png" alt="this slowpoke moves" width="170px" style="margin-left:-18px; rotate:270deg; margin-top:0px;" />`);
                        elapsedTime = 0;
                        startTime = Date.now();
                        clearTimeout(timeoutId);
                        displayTime(0, 0, 0, 0);
                    } else if (inserts == 1 && code == 0 && arus <= 0.2) {
                        loopingId++;
                        console.log("Loading to Finish");
                        if (loopingId > 3) {
                            loopingId = 0;
                            insertData();
                            updateData2();
                        }
                        $('#status_btn').html(`Charging ${volt} Volt..`);
                        $('#kwh').html(`${energy} kWh`);
                        $('#power').html(`${arus} A`)
                        document.getElementById('fullpage').style.display = 'none';
                        document.getElementById('chargingpage').style.display = 'block';
                        // updateData();
                        $('.desc-font').removeClass('full-font').addClass('charge-font')
                        $('#loading').removeClass('loading-off').addClass('loading');
                        $('#chargingblock').html(`<img src="./images/car-eve.png" alt="this slowpoke moves" width="170px" style="margin-left:-20px; rotate:270deg; margin-top:0px;"/>`);
                        startStopwatch();
                    } else if (inserts == 1 && code == 1) {
                        loopingId++;
                        console.log("Finish");
                        if (loopingId > 20) {
                            loopingId = 0;
                            updateStatus();
                        }
                        $('#status_btn').html(`Finish Charging...`);
                        get_data_logcharging();
                        // updateData2();
                        document.getElementById('fullpage').style.display = 'block';
                        document.getElementById('chargingpage').style.display = 'none';
                        $('.header').removeClass('header-run').addClass('.header')//ubah
                    }
                } else if (status == 'ON' && arus >= 0.2) { //ON AND ARUS 1
                    $('#status_btn').html(`Charging ${volt} Volt..`);
                    $('#kwh').html(`${energy} kWh`);
                    $('#power').html(`${arus} A`);
                    document.getElementById('fullpage').style.display = 'none';
                    document.getElementById('chargingpage').style.display = 'block';
                    insertTime()
                    updateData();
                    $('.header').removeClass('header-ads').addClass('header-run') //ubah

                    $('#chargingblock').html(`<img src="./images/car-eve.png" alt="this slowpoke moves" width="170px" style="margin-left:-20px; rotate:270deg; margin-top:0px;"/>`);
                    startStopwatch();
                } else {
                    $('#status_btn').html('StandBy...');
                    $('#kwh').html(`0.00 kWh`);
                    $('#power').html(`0 A`)
                    document.getElementById('fullpage').style.display = 'none';
                    document.getElementById('chargingpage').style.display = 'block';
                    if (code != 0) { //Kondisi Idle apabila stuck code 1 akan update menjadi 0
                        updateStatus();
                    }
                    // $('.header').removeClass('.header').addClass('header-ads')//ubah
                    $('.header').removeClass('.header').addClass('header-ads');
                    $('.description-line').removeClass('.description-line').addClass('description-line-hide');//ubah
                    $('.charging-block').removeClass('.charging-block').addClass('charging-block-hide');//ubah
                    $('.custom-btn').removeClass('.custom-btn').addClass('custom-btn-hide');//ubah

                    if (usage_status == 'Belum Terpakai') {
                        loopingId++;
                        console.log("Barcode");
                        if (loopingId > 60) {
                            loopingId = 0;
                            updateVoucher();
                        }
                        $('#chargingblock').html(`<div class="charge-font desc-font" style="margin-left: -8px; margin-top: 30px; font-size: 30px"> You Code is <br> ${voucher}</div>`);
                        //console.log(0);
                    } else {
                        //console.log(0)

                        $('#chargingblock').html(`<img src="./images/ganti-qr.jpg" alt="this slowpoke moves" width="133px" height="133px" style="rotate:270deg; margin-top:31px;"/>`);
                        console.log(1);
                    }
                    elapsedTime = 0;
                    startTime = Date.now();
                    clearTimeout(timeoutId);
                    displayTime(0, 0, 0, 0);
                }
            },
            complete: function() {
                setTimeout(function() {
                    get_data_charging();
                }, 1000);
            },

        })

        // return result
    }

    function insertTime() {
    // Using jQuery AJAX to make a POST request to selecttoinsert.php
        var time = document.getElementById('time').innerHTML;
    $.ajax({
        type: "POST",
        url: "api/inserttime.php", // Replace with the actual path
        data: {
                // ev_id: id,
                // kwh: kwh,
                time: time
            },
        success: function(response) {
            // Handle the response from the server if needed
            console.log(response);
        },
        error: function(error) {
            // Handle the error if the AJAX request fails
            console.error("AJAX request failed:", error);
        }
    });
}

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
                            <td class="legend-saldo">${energy}</td>
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

    function displayTime(hour, minutes, seconds) {
        var stopwatch = document.getElementById('time');
        hour = hour < 10 ? '0' + hour : hour;
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;
        stopwatch.innerHTML = hour + ':' + minutes + ':' + seconds;
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
