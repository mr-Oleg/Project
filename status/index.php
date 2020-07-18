<?php  

    $cam_id = $_GET['id'];
    if(!isset($cam_id)){
        echo "Камера не найдена";
        exit();
    }

    include("php/db.php");

    $con = get_connection();

    $query = "SELECT count(1) FROM cam_address WHERE addr_id = {$cam_id}";
    $response = $con->query($query);
    if($response === false){
        echo "Ошибка запроса в базу данных";
        exit();
    }

    $is_id = $response->fetch(PDO::FETCH_NUM)[0];
    if($is_id == 0){
        echo "Камера не найдена";
        exit();
    }

    $query = "SELECT * FROM recognize WHERE rec_id = {$cam_id}";
    $response = $con->query($query);
    if($response === false){
        echo "Ошибка запроса в базу данных";
        exit();
    }
    $to_recognize = $response->fetch(PDO::FETCH_ASSOC);

    $query = "SELECT * FROM sensitivity WHERE cam_id = {$cam_id}";
    $response = $con->query($query);
    if($response === false){
        echo "Ошибка запроса в базу данных";
        exit();
    }
    $sensitivity = $response->fetch(PDO::FETCH_ASSOC);

?>

<!doctype html>
<html lang="ru">

    <head>
        <meta charset="utf-8" />
        <title>Статус работника</title>
        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>

    <body class="bg-light">
        <div class="container-fluid pb-5">
            <div class="row my-4 mx-1">
                <div class="col-5 ">
                    <div class="row border border-dark rounded bg-secondary p-1 shadow my-3 d-none">
                        <video id="video" src="" class="w-100" autoplay />
                    </div>
                    <div class="row border border-dark rounded bg-secondary p-1 shadow my-3 d-none">
                        <canvas id="canvas" width="640" height="480" type="video/mp4"></canvas>
                    </div>
                    <div class="row border border-dark rounded bg-secondary p-1 shadow my-3" style="min-height: 10em">
                        <img id="image" class="w-100"></img>
                    </div>
                    <div class="row ml-2 my-3">
                        <div class="rounded-circle p-1 bg-dark">
                            <div class="rounded-circle p-3 bg-danger"></div>
                        </div>
                        <div class="h4 p-1 mb-0"> - Плохо</div>
                    </div>
                    <div class="row ml-2 my-3">
                        <div class="rounded-circle p-1 bg-dark">
                            <div class="rounded-circle p-3 bg-warning"></div>
                        </div>
                        <div class="h4 p-1 mb-0"> - Нейтрально</div>
                    </div>
                    <div class="row ml-2 my-3">
                        <div class="rounded-circle p-1 bg-dark">
                            <div class="rounded-circle p-3 bg-success"></div>
                        </div>
                        <div class="h4 p-1 mb-0"> - Хорошо</div>
                    </div>
                    <div class="row ml-2 my-3">
                        <div class="rounded-circle p-1 bg-dark">
                            <div class="rounded-circle p-3 bg-secondary"></div>
                        </div>
                        <div class="h4 p-1 mb-0"> - Нет ответа</div>
                    </div>
                    <div class="row ml-2 my-3">
                        <div class="rounded-circle p-1 bg-dark">
                            <div class="rounded-circle p-3 bg-dark"></div>
                        </div>
                        <div class="h4 p-1 mb-0"> - Выключено</div>
                    </div>
                </div>
                <div class="col-7">

                    <div class="mx-5">
                        <div class="row my-3">
                            <div class="checkbox mb-0 h3 pt-2 mr-5" style="line-height: 0">
                                <input class="custom-checkbox" type="checkbox" id="check_exist" name="check_exist">
                                <label for="check_exist" class="mb-0" onclick="check('exist')"></label>
                            </div>
                            <div class="rounded-circle p-1 bg-dark mr-5">
                                <div class="rounded-circle p-3 bg-dark" id="sig_exist"></div>
                            </div>
                            <div class="h4 p-1 mb-0 cursor-pointer" onclick="toggle_settings('exist')">На рабочем месте</div>
                        </div>
                        <div class="row my-3 settings" id="settings_exist">
                            <div class="col-md-7 text-center p-0 mr-5">
                                <form>
                                    <div class="form-group">
                                        <label for="sense_exist">Чувствительность</label>
                                        <input type="range" class="form-control-range" id="sense_exist">
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4 p-0"><button class="btn btn-primary text-center" onclick="location_subs('exist')">Слушатели</button></div>
                        </div>
                    </div>

                    <div class="mx-5">
                        <div class="row my-3">
                            <div class="checkbox mb-0 h3 pt-2 mr-5" style="line-height: 0">
                                <input class="custom-checkbox" type="checkbox" id="check_anger" name="check_anger">
                                <label for="check_anger" class="mb-0" onclick="check('anger')"></label>
                            </div>
                            <div class="rounded-circle p-1 bg-dark mr-5">
                                <div class="rounded-circle p-3 bg-dark" id="sig_anger"></div>
                            </div>
                            <div class="h4 p-1 mb-0 cursor-pointer" onclick="toggle_settings('anger')">Агрессия</div>
                        </div>
                        <div class="row my-3 settings" id="settings_anger">
                            <div class="col-md-7 text-center p-0 mr-5">
                                <form>
                                    <div class="form-group">
                                        <label for="sense_anger">Чувствительность</label>
                                        <input type="range" class="form-control-range" id="sense_anger">
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4 p-0"><button class="btn btn-primary text-center" onclick="location_subs('anger')">Слушатели</button></div>
                        </div>
                    </div>

                    <div class="mx-5">
                        <div class="row my-3">
                            <div class="checkbox mb-0 h3 pt-2 mr-5" style="line-height: 0">
                                <input class="custom-checkbox" type="checkbox" id="check_tire" name="check_tire">
                                <label for="check_tire" class="mb-0" onclick="check('tire')"></label>
                            </div>
                            <div class="rounded-circle p-1 bg-dark mr-5">
                                <div class="rounded-circle p-3 bg-dark" id="sig_tire"></div>
                            </div>
                            <div class="h4 p-1 mb-0 cursor-pointer" onclick="toggle_settings('tire')">Усталость</div>
                        </div>
                        <div class="row my-3 settings" id="settings_tire">
                            <div class="col-md-7 text-center p-0 mr-5">
                                <form>
                                    <div class="form-group">
                                        <label for="sense_tire">Чувствительность</label>
                                        <input type="range" class="form-control-range" id="sense_tire">
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4 p-0"><button class="btn btn-primary text-center" onclick="location_subs('tire')">Слушатели</button></div>
                        </div>
                    </div>

                    <div class="mx-5">
                        <div class="row my-3">
                            <div class="checkbox mb-0 h3 pt-2 mr-5" style="line-height: 0">
                                <input class="custom-checkbox" type="checkbox" id="check_stroke" name="check_stroke">
                                <label for="check_stroke" class="mb-0" onclick="check('stroke')"></label>
                            </div>
                            <div class="rounded-circle p-1 bg-dark mr-5">
                                <div class="rounded-circle p-3 bg-dark" id="sig_stroke"></div>
                            </div>
                            <div class="h4 p-1 mb-0 cursor-pointer" onclick="toggle_settings('stroke')">Инсульт</div>
                        </div>
                        <div class="row my-3 settings" id="settings_stroke">
                            <div class="col-md-7 text-center p-0 mr-5">
                                <form>
                                    <div class="form-group">
                                        <label for="sense_stroke">Чувствительность</label>
                                        <input type="range" class="form-control-range" id="sense_stroke">
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4 p-0"><button class="btn btn-primary text-center" onclick="location_subs('stroke')">Слушатели</button></div>
                        </div>
                    </div>

                    <div class="mx-5">
                        <div class="row my-3">
                            <div class="checkbox mb-0 h3 pt-2 mr-5" style="line-height: 0">
                                <input class="custom-checkbox" type="checkbox" id="check_sad" name="check_sad">
                                <label for="check_sad" class="mb-0" onclick="check('sad')"></label>
                            </div>
                            <div class="rounded-circle p-1 bg-dark mr-5">
                                <div class="rounded-circle p-3 bg-dark" id="sig_sad"></div>
                            </div>
                            <div class="h4 p-1 mb-0 cursor-pointer" onclick="toggle_settings('sad')">Печаль</div>
                        </div>
                        <div class="row my-3 settings" id="settings_sad">
                            <div class="col-md-7 text-center p-0 mr-5">
                                <form>
                                    <div class="form-group">
                                        <label for="sense_sad">Чувствительность</label>
                                        <input type="range" class="form-control-range" id="sense_sad">
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4 p-0"><button class="btn btn-primary text-center" onclick="location_subs('sad')">Слушатели</button></div>
                        </div>
                    </div>

                    <div class="mx-5">
                        <div class="row my-3">
                            <div class="checkbox mb-0 h3 pt-2 mr-5" style="line-height: 0">
                                <input class="custom-checkbox" type="checkbox" id="check_happy" name="check_happy">
                                <label for="check_happy" class="mb-0" onclick="check('happy')"></label>
                            </div>
                            <div class="rounded-circle p-1 bg-dark mr-5">
                                <div class="rounded-circle p-3 bg-dark" id="sig_happy"></div>
                            </div>
                            <div class="h4 p-1 mb-0 cursor-pointer" onclick="toggle_settings('happy')">Радость</div>
                        </div>
                        <div class="row my-3 settings" id="settings_happy">
                            <div class="col-md-7 text-center p-0 mr-5">
                                <form>
                                    <div class="form-group">
                                        <label for="sense_happy">Чувствительность</label>
                                        <input type="range" class="form-control-range" id="sense_happy">
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4 p-0"><button class="btn btn-primary text-center" onclick="location_subs('happy')">Слушатели</button></div>
                        </div>
                    </div>

                    <div class="row ml-5 mt-5">
                        <button type="button" class="btn btn-primary" id="btn-start" onclick="start()">Старт</button>
                        <button type="button" class="btn btn-primary ml-2" id="btn-stop" disabled onclick="stop()">Стоп</button>
                    </div>
                </div>
            </div>
        </div>
        
    </body>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $("#check_exist")[0].checked = <?= $to_recognize['rec_existance'] == 1?1:0; ?>;
        $("#check_anger")[0].checked = <?= $to_recognize['rec_anger'] == 1?1:0; ?>;
        $("#check_tire")[0].checked = <?= $to_recognize['rec_tire'] == 1?1:0; ?>;
        $("#check_stroke")[0].checked = <?= $to_recognize['rec_stroke'] == 1?1:0; ?>;
        $("#check_sad")[0].checked = <?= $to_recognize['rec_sadness'] == 1?1:0; ?>;
        $("#check_happy")[0].checked = <?= $to_recognize['rec_happiness'] == 1?1:0; ?>;

        $("#sense_exist")[0].value = <?= $sensitivity['sense_exist'] * 100?>;
        $("#sense_anger")[0].value = <?= $sensitivity['sense_anger'] * 100?>;
        $("#sense_tire")[0].value = <?= $sensitivity['sense_tire'] * 100?>;
        $("#sense_stroke")[0].value = <?= $sensitivity['sense_stroke'] * 100?>;
        $("#sense_sad")[0].value = <?= $sensitivity['sense_sad'] * 100?>;
        $("#sense_happy")[0].value = <?= $sensitivity['sense_happy'] * 100?>;

        $("#sense_exist").change(function(){change_sense("exist", this.value)});
        $("#sense_anger").change(function(){change_sense("anger", this.value)});
        $("#sense_tire").change(function(){change_sense("tire", this.value)});
        $("#sense_stroke").change(function(){change_sense("stroke", this.value)});
        $("#sense_sad").change(function(){change_sense("sad", this.value)});
        $("#sense_happy").change(function(){change_sense("happy", this.value)});

        if($("#check_exist")[0].checked){
            $("#sig_exist").removeClass("bg-dark");
            $("#sig_exist").addClass("bg-secondary");
        }
        if($("#check_anger")[0].checked){
            $("#sig_anger").removeClass("bg-dark");
            $("#sig_anger").addClass("bg-secondary");
        }
        if($("#check_tire")[0].checked){
            $("#sig_tire").removeClass("bg-dark");
            $("#sig_tire").addClass("bg-secondary");
        }
        if($("#check_stroke")[0].checked){
            $("#sig_stroke").removeClass("bg-dark");
            $("#sig_stroke").addClass("bg-secondary");
        }
        if($("#check_sad")[0].checked){
            $("#sig_sad").removeClass("bg-dark");
            $("#sig_sad").addClass("bg-secondary");
        }
        if($("#check_happy")[0].checked){
            $("#sig_happy").removeClass("bg-dark");
            $("#sig_happy").addClass("bg-secondary");
        }

        $(".settings").toggle();

        var canvas = $("#canvas")[0];
        var video = $("#video")[0];
        var img_box = $("#image")[0]
        var ctx = canvas.getContext("2d");
        var cameraInterval;
        var localMediaStream = null;
        var cam_id = <?= $cam_id ?>;
        var started = false;

        navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
        window.URL = window.URL || window.webkitURL;
        navigator.getUserMedia({video: true}, function(stream){video.srcObject = stream, localMediaStream = stream;}, function(){console.log("camera is not working")});

        function check(mode) {
            let checked = $("#check_"+mode)[0].checked;
            let request = {
                "type" : mode,
                "id" : cam_id,
                "value" : checked?0:1
            }
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: 'php/server.php?action=check_recognize',
                data: "data="+JSON.stringify(request),
                success: function(data){
                    if(data["type"]=="success"){
                        if(checked){
                            $("#sig_"+mode).removeClass("bg-secondary");
                            $("#sig_"+mode).removeClass("bg-success");
                            $("#sig_"+mode).removeClass("bg-warning");
                            $("#sig_"+mode).removeClass("bg-danger");
                            $("#sig_"+mode).addClass("bg-dark");
                        } else {
                            $("#sig_"+mode).removeClass("bg-dark");
                            $("#sig_"+mode).addClass("bg-secondary");
                        }
                    }
                }
            });
        }

        function set_signal(mode, signal){
            $("#sig_"+mode).removeClass("bg-secondary");
            $("#sig_"+mode).removeClass("bg-success");
            $("#sig_"+mode).removeClass("bg-warning");
            $("#sig_"+mode).removeClass("bg-danger");
            $("#sig_"+mode).removeClass("bg-dark");
            switch(signal){
                case -1:
                    $("#sig_"+mode).addClass("bg-dark");
                    break;
                case 0:
                    $("#sig_"+mode).addClass("bg-secondary");
                    break;
                case 1:
                    $("#sig_"+mode).addClass("bg-success");
                    break;
                case 2:
                    $("#sig_"+mode).addClass("bg-warning");
                    break;
                case 3:
                    $("#sig_"+mode).addClass("bg-danger");
                    break;
            }
        }

        function set_check(mode, check){
            let to_set = true;
            if(check == 0 || check == false){
                to_set = false
            }
            $("#check_"+mode)[0].checked = to_set
        }

        function start(){
            started = true;
            cameraInterval = setInterval(function(){snapshot();}, 1000);
            $("#btn-start")[0].disabled = true;
            $("#btn-stop")[0].disabled = false;
        }

        function stop(){
            started = false;
            clearInterval(cameraInterval);
            img_box.src="";
            setTimeout(function(){img_box.src="";},1000);
            $("#btn-start")[0].disabled = false;
            $("#btn-stop")[0].disabled = true;
            set_signal("exist", 0);
            set_signal("anger", 0);
            set_signal("tire", 0);
            set_signal("stroke", 0);
            set_signal("sad", 0);
            set_signal("happy", 0);
        }

        function snapshot(){
            if(localMediaStream){
                ctx.drawImage(video, 0, 0);
                send_img();
            }
        }

        function send_img(){
            let b64 = canvas.toDataURL().split(",")[1];
            let request = {
                "id" : cam_id,
                "img" : b64
            }
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: 'php/server.php?action=process_img',
                data: "data="+JSON.stringify(request),
                success: function(data){
                    if(started){
                        let b64 = data['message']['img'];
                        let img = new Image();
                        img.src = "data:image/png;base64," + b64.split(" ").join("+");
                        img_box.src = img.src;
                        let status = data['message']['status'];
                        if(status){
                            set_signal("exist", status['exist']);
                            set_signal("anger", status['anger']);
                            set_signal("tire", status['tire']);
                            set_signal("stroke", status['stroke']);
                            set_signal("sad", status['sadness']);
                            set_signal("happy", status['happiness']);
                        }
                    }
                }
            });
        }

        function location_subs(mode){
            document.location = "subscribers.php?id="+cam_id+"&mode="+mode;
        }

        function toggle_settings(mode){
            $("#settings_"+mode).toggle();
        }

        function change_sense(mode, value){
            let checked = $("#check_"+mode)[0].checked;
            let request = {
                "id" : cam_id,
                "type" : mode,
                "value" : value/100
            }
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: 'php/server.php?action=change_sense',
                data: "data="+JSON.stringify(request)
            });
        }

    </script>

</html>