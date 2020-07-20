<?php  

    $cam_id = $_GET['id'];
    if(!isset($cam_id)){
        echo "Камера не найдена";
        exit();
    }

    $mode = $_GET['mode'];
	if(!isset($cam_id)){
        echo "Не выбрана цель";
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

    $query = "SELECT * FROM subscribers WHERE cam_id = {$cam_id} AND sub_mode = '{$mode}'";
    $response = $con->query($query);
    if($response === false){
        echo "Ошибка запроса в базу данных";
        exit();
    }
    $subs = $response->fetchAll(PDO::FETCH_ASSOC);
    
?>


<!doctype html>
<html lang="ru">

    <head>
        <meta charset="utf-8" />
        <title>Настройка слушателей</title>
        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
	
	<body class="bg-light">
		<div class="container">
		
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8 text-center" style="font-size: 150%; font-weight: bolder">
					<span>Настройка слушателей</span>
				</div>
				<div class="col-md-2"></div>
			</div>
			
			<div class="row">
			
				<div class="col-md-12">


					<div class="panel-group" id="collapse-group">
    				

						<div class="panel panel-danger">
						
							<div class="panel-heading">
								<a data-toggle="collapse" style="font-size: 150%; font-weight: bolder" data-parent="#collapse-group" href="#activeListeners">Текущие слушатели</a>
							</div>
							<div id="activeListeners" class="collapse">
        
								<div class="panel-body">
									<div class="row" style="margin-top:1%">
										<table class="table table-bordered text-center">
											<thead>
												<tr>
													<th>#</th>
													<th>Адрес</th>
     												<th>Действие</th>
    											</tr>
  											</thead>
  											<tbody id="subs-table-body">
    											<?php foreach ($subs as $key => $sub): ?>
    												<tr>
														<th scope="row"><?= $key+1 ?></th>
														<th id=<?= "'sub-" . $sub['sub_id'] . "'"?> class="sub-adr"> <?= $sub['sub_adr'] ?> </th>
	     												<th><button type="button" class="btn btn-danger" onclick="del_sub(this)">Удалить</button></th>
	    											</tr>
	    										<?php endforeach; ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-12 text-left" style="font-size: 150%; font-weight: bolder">
								<span>Добавить слушателя</span>
							</div>
						</div>
						
						<div class="row" style="margin-top:1%">
						
							<div class="col-md-12">
								<div class="input-group mb-3">
									<input id="input_adr" type="text" class="form-control" placeholder="Введите IP-адрес" aria-label="Recipient's username" aria-describedby="basic-addon2">
									<div class="input-group-append">
										<button class="btn btn-outline-success" type="button" onclick="add_sub()">Добавить</button>
									</div>
								</div>
							</div>
							
						</div>
						
					</div>
				
				</div>
				
			</div>
			
		</div>
	
		<div id="message_modal" class="modal" tabindex="-1" style="display:none;">
			<div class="modal-dialog modal-sm">
			  	<div class="modal-content">
					<div class="modal-header">
					  <h4 class="modal-title">Уведомление</h4>
					</div>
					<div class="modal-body text-center" id="textmessage">
                        <span id="message_modal_text"></span>
                        <br>
						<button class="btn btn-primary mt-5" data-dismiss="modal" onclick="$('#message_modal').hide();">ОК</button>
                    </div>
			  	</div>
			</div>
        </div>
	
	</body>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script type="text/javascript">

    	var cam_id = <?= $cam_id ?>;
    	var mode = <?= "'" . $mode . "'" ?>;
    	
    	function show_modal(text){
    		$('#message_modal_text')[0].innerText = text;
    		$('#message_modal').show();
    	}

    	function add_sub(){
    		let input_adr = $('#input_adr')[0].value.trim();
    		if(input_adr == ""){
    			show_modal("Введите адрес");
    			return;
    		}

            let request = {
                "type" : mode,
                "id" : cam_id,
                "value" : input_adr
            }
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: 'php/server.php?action=add_subscriber',
                data: "data="+JSON.stringify(request),
                success: function(data){
                    if(data["type"]=="success"){
                        window.location.reload();
                    } else if(data["type"]=="error"){
                        show_modal(data["message"]);
                    }
                }
            });
    	}

    	function del_sub(button){
    		let sub_node = button.parentNode.parentNode.getElementsByClassName("sub-adr")[0];
    		let value = sub_node.innerText;
    		let sub_id = sub_node.id.split("-")[1];

    		let request = {
                "type" : mode,
                "id" : cam_id,
                "value" : value,
                "sub_id" : sub_id
            }
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: 'php/server.php?action=del_subscriber',
                data: "data="+JSON.stringify(request),
                success: function(data){
                    if(data["type"]=="success"){
                        window.location.reload();
                    } else if(data["type"]=="error"){
                        show_modal(data["message"]);
                    }
                }
            });
    	}
    </script>

</html>