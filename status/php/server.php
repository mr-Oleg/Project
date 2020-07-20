<?

$success=[
	"type" => "success",
	"message" => NULL
];

$error=[
	"type" => "error",
	"message" => ""
];

if(!isset($_GET['action'])){
	$error["message"] = "Неверный запрос";
	response($error);
}


include("requests.php");
include("db.php");

switch ($_GET['action']){
	case 'check_recognize':
		$data = $_POST["data"];
		if(!isset($data)){
			$error["message"] = "Неверные параметры";
			response($error);
		}
		$data = json_decode($data, true);
		$id = $data["id"];
		$type = $data["type"];
		$value = $data["value"];
		if(!isset($id) || !isset($type) || !isset($value)){
			$error["message"] = "Неверные параметры";
			response($error);
		}
		$message = check_recognize($type, $id, $value);
		$success["message"] = $message;
		response($success);
		break;

	case 'process_img':
		$data = $_POST["data"];
		if(!isset($data)){
			$error["message"] = "Неверные параметры";
			response($error);
		}
		$data = json_decode($data, true);
		$img = $data["img"];
		$id = $data["id"];
		if(!isset($img) || !isset($id)){
			$error["message"] = "Неверные параметры";
			response($error);
		}
		$message = process_img($id, $img);
		$success["message"] = $message;
		response($success);
		break;

	case 'change_sense':
		$data = $_POST["data"];
		if(!isset($data)){
			$error["message"] = "Неверные параметры";
			response($error);
		}
		$data = json_decode($data, true);
		$id = $data["id"];
		$type = $data["type"];
		$value = $data["value"];
		if(!isset($id) || !isset($type) || !isset($value)){
			$error["message"] = "Неверные параметры";
			response($error);
		}
		$message = change_sense($type, $id, $value);
		$success["message"] = $message;
		response($success);
		break;

	case 'add_subscriber':
		$data = $_POST["data"];
		if(!isset($data)){
			$error["message"] = "Неверные параметры";
			response($error);
		}
		$data = json_decode($data, true);
		$id = $data["id"];
		$type = $data["type"];
		$value = $data["value"];
		if(!isset($id) || !isset($type) || !isset($value)){
			$error["message"] = "Неверные параметры";
			response($error);
		}
		$message = add_subscriber($type, $id, $value);
		$success["message"] = $message;
		response($success);
		break;

	case 'del_subscriber':
		$data = $_POST["data"];
		if(!isset($data)){
			$error["message"] = "Неверные параметры";
			response($error);
		}
		$data = json_decode($data, true);
		$id = $data["id"];
		$type = $data["type"];
		$value = $data["value"];
		$sub_id = $data["sub_id"];
		if(!isset($id) || !isset($type) || !isset($value) || !isset($sub_id)){
			$error["message"] = "Неверные параметры";
			response($error);
		}
		$message = del_subscriber($type, $id, $sub_id, $value);
		$success["message"] = $message;
		response($success);
		break;
	
	default:
		$error["message"] = "Неверный запрос";
		response($error);
		break;
}



/*_____________Отправить ответ______________*/
function response($response){
	exit(json_encode($response));
}



/*_____________Вкл/выкл распознавания______________*/
function check_recognize($type, $id, $value){
	global $error;
	switch ($type) {
		case 'exist':
			if($value==0) $rec_value = 0;
			else $rec_value = 1;
			$query = "UPDATE recognize SET rec_existance = {$rec_value} WHERE rec_id = {$id}";
			$con = get_connection();
		    $response = $con->query($query);
		    if($response === false){
		        $error["message"] = "Ошибка запроса в базу данных";
				response($error);
		    }
			break;

		case 'anger':
			if($value==0) $rec_value = 0;
			else $rec_value = 1;
			$query = "UPDATE recognize SET rec_anger = {$rec_value} WHERE rec_id = {$id}";
			$con = get_connection();
		    $response = $con->query($query);
		    if($response === false){
		        $error["message"] = "Ошибка запроса в базу данных";
				response($error);
		    }
			break;
			
		case 'tire':
			if($value==0) $rec_value = 0;
			else $rec_value = 1;
			$query = "UPDATE recognize SET rec_tire = {$rec_value} WHERE rec_id = {$id}";
			$con = get_connection();
		    $response = $con->query($query);
		    if($response === false){
		        $error["message"] = "Ошибка запроса в базу данных";
				response($error);
		    }
			break;

		case 'stroke':
			if($value==0) $rec_value = 0;
			else $rec_value = 1;
			$query = "UPDATE recognize SET rec_stroke = {$rec_value} WHERE rec_id = {$id}";
			$con = get_connection();
		    $response = $con->query($query);
		    if($response === false){
		        $error["message"] = "Ошибка запроса в базу данных";
				response($error);
		    }
			break;

		case 'sad':
			if($value==0) $rec_value = 0;
			else $rec_value = 1;
			$query = "UPDATE recognize SET rec_sadness = {$rec_value} WHERE rec_id = {$id}";
			$con = get_connection();
		    $response = $con->query($query);
		    if($response === false){
		        $error["message"] = "Ошибка запроса в базу данных";
				response($error);
		    }
			break;

		case 'happy':
			if($value==0) $rec_value = 0;
			else $rec_value = 1;
			$query = "UPDATE recognize SET rec_happiness = {$rec_value} WHERE rec_id = {$id}";
			$con = get_connection();
		    $response = $con->query($query);
		    if($response === false){
		        $error["message"] = "Ошибка запроса в базу данных";
				response($error);
		    }
			break;

		default:
			$error["message"] = "Неверные параметры";
			response($error);
			break;
	}

	return "Успех";
}



/*_____________Распознавание______________*/
function process_img($id, $img){
	global $error;
	$con = get_connection();
	$query = "SELECT * FROM recognize WHERE rec_id = {$id}";
	$response = $con->query($query);
	if($response === false){
        $error["message"] = "Ошибка запроса в базу данных";
		response($error);
    }
    $recs = $response->fetch(PDO::FETCH_ASSOC);

    $query = "SELECT * FROM sensitivity WHERE cam_id = {$id}";
	$response = $con->query($query);
	if($response === false){
        $error["message"] = "Ошибка запроса в базу данных";
		response($error);
    }
    $senses = $response->fetch(PDO::FETCH_ASSOC);

    $exist = -1;
    $anger = -1;
    $tire = -1;
    $stroke = -1;
	$sadness = -1;
	$happiness = -1;

    if($recs["rec_anger"]==1 || $recs["rec_sadness"]==1 || $recs["rec_happiness"]==1){

    	$py_response = py_request("rec_emotions", ["img" => $img]);

		if($py_response['type'] == "success"){

			$emotions = $py_response['message'];

			if($recs["rec_anger"]==1){
				$anger_value = $emotions[0];
				if($anger_value > $senses['sense_anger']){
					$anger = 3;
					$query = "SELECT sub_adr FROM subscribers WHERE cam_id = {$id} AND sub_mode = 'anger' ";
					$response = $con->query($query);
					if($response === false){
				        $error["message"] = "Ошибка запроса в базу данных";
						response($error);
				    }
				    $urls_row = $response->fetchAll(PDO::FETCH_NUM);
				    $urls = [];
				    foreach($urls_row as $key => $value){
				    	$urls[$key] = $value[0];
				    }
				    $anger_message = [
				    	"cam_id" => $id,
				    	"mode" => "anger",
				    	"message" => "Обнаружены признаки агрессии"
				    ];
				    send_requests($urls,$anger_message);
				}
				else if($anger_value > $senses['sense_anger'] / 2) $anger = 2;
				else if($anger_value >= 0) $anger = 1;
				else $anger = 0;
			}

			if($recs["rec_sadness"]==1){
				$sadness_value = $emotions[1];
				if($sadness_value > $senses['sense_sad']) $sadness = 2;
				else if($sadness_value > 0) $sadness = 1;
				else $sadness = 0;
			}

			if($recs["rec_happiness"]==1){
				$happiness_value = $emotions[2];
				if($happiness_value > $senses['sense_happy']) $happiness = 1;
				else if($happiness_value > 0) $happiness = 2;
				else $sadness = 0;
			}
		}
    }

    if($recs["rec_existance"]==1){
    	$exist = 0;
    }

    if($recs["rec_tire"]==1){
    	$tire = 0;
    }

    if($recs["rec_stroke"]==1){
    	$stroke = 0;
    }


	return [
		'img' => $img,
		'status' => [
			'anger_value' => $anger_value,
			'sadness_value' => $sadness_value,
			'happiness_value' => $happiness_value,
			'exist' => $exist,
			'anger' => $anger,
			'tire' => $tire,
			'stroke' => $stroke,
			'anger' => $anger,
			'sadness' => $sadness,
			'happiness' => $happiness
		]
	];

}


/*_____________Изменить чувствительность______________*/
function change_sense($type, $id, $value){
	global $error;
	switch ($type) {
		case 'exist':
			$query = "UPDATE sensitivity SET sense_exist = {$value} WHERE cam_id = {$id}";
			$con = get_connection();
		    $response = $con->query($query);
		    if($response === false){
		        $error["message"] = "Ошибка запроса в базу данных";
				response($error);
		    }
			break;

		case 'anger':
			$query = "UPDATE sensitivity SET sense_anger = {$value} WHERE cam_id = {$id}";
			$con = get_connection();
		    $response = $con->query($query);
		    if($response === false){
		        $error["message"] = "Ошибка запроса в базу данных";
				response($error);
		    }
			break;
			
		case 'tire':
			$query = "UPDATE sensitivity SET sense_tire = {$value} WHERE cam_id = {$id}";
			$con = get_connection();
		    $response = $con->query($query);
		    if($response === false){
		        $error["message"] = "Ошибка запроса в базу данных";
				response($error);
		    }
			break;

		case 'stroke':
			$query = "UPDATE sensitivity SET sense_stroke = {$value} WHERE cam_id = {$id}";
			$con = get_connection();
		    $response = $con->query($query);
		    if($response === false){
		        $error["message"] = "Ошибка запроса в базу данных";
				response($error);
		    }
			break;

		case 'sad':
			$query = "UPDATE sensitivity SET sense_sad = {$value} WHERE cam_id = {$id}";
			$con = get_connection();
		    $response = $con->query($query);
		    if($response === false){
		        $error["message"] = "Ошибка запроса в базу данных";
				response($error);
		    }
			break;

		case 'happy':
			$query = "UPDATE sensitivity SET sense_happy = {$value} WHERE cam_id = {$id}";
			$con = get_connection();
		    $response = $con->query($query);
		    if($response === false){
		        $error["message"] = "Ошибка запроса в базу данных";
				response($error);
		    }
			break;

		default:
			$error["message"] = "Неверные параметры";
			response($error);
			break;
	}

	return "Успех";
}



/*_____________Добавить подписчика______________*/
function add_subscriber($type, $id, $value){
	$value = addslashes($value);
	global $error;
	switch ($type) {
		case 'exist':
			$query = "INSERT INTO subscribers (cam_id, sub_mode, sub_adr) VALUES ({$id}, 'exist', '{$value}')";
			$con = get_connection();
		    $response = $con->query($query);
		    if($response === false){
		        $error["message"] = "Ошибка запроса в базу данных";
				response($error);
		    }
			break;

		case 'anger':
			$query = "INSERT INTO subscribers (cam_id, sub_mode, sub_adr) VALUES ({$id}, 'anger', '{$value}')";
			$con = get_connection();
		    $response = $con->query($query);
		    if($response === false){
		        $error["message"] = "Ошибка запроса в базу данных";
				response($error);
		    }
			break;
			
		case 'tire':
			$query = "INSERT INTO subscribers (cam_id, sub_mode, sub_adr) VALUES ({$id}, 'tire', '{$value}')";
			$con = get_connection();
		    $response = $con->query($query);
		    if($response === false){
		        $error["message"] = "Ошибка запроса в базу данных";
				response($error);
		    }
			break;

		case 'stroke':
			$query = "INSERT INTO subscribers (cam_id, sub_mode, sub_adr) VALUES ({$id}, 'stroke', '{$value}')";
			$con = get_connection();
		    $response = $con->query($query);
		    if($response === false){
		        $error["message"] = "Ошибка запроса в базу данных";
				response($error);
		    }
			break;

		case 'sad':
			$query = "INSERT INTO subscribers (cam_id, sub_mode, sub_adr) VALUES ({$id}, 'sad', '{$value}')";
			$con = get_connection();
		    $response = $con->query($query);
		    if($response === false){
		        $error["message"] = "Ошибка запроса в базу данных";
				response($error);
		    }
			break;

		case 'happy':
			$query = "INSERT INTO subscribers (cam_id, sub_mode, sub_adr) VALUES ({$id}, 'happy', '{$value}')";
			$con = get_connection();
		    $response = $con->query($query);
		    if($response === false){
		        $error["message"] = "Ошибка запроса в базу данных";
				response($error);
		    }
			break;

		default:
			$error["message"] = "Неверные параметры";
			response($error);
			break;
	}

	return "Успех";
}



/*_____________Удалить подписчика______________*/
function del_subscriber($type, $id, $sub_id, $value){
	$value = addslashes($value);
	global $error;
	switch ($type) {
		case 'exist':
			$query = "DELETE FROM subscribers WHERE sub_id = {$sub_id} AND cam_id = {$id} AND sub_mode = 'exist' AND sub_adr = '{$value}'";
			$con = get_connection();
		    $response = $con->query($query);
		    if($response === false){
		        $error["message"] = "Ошибка запроса в базу данных";
				response($error);
		    }
			break;

		case 'anger':
			$query = "DELETE FROM subscribers WHERE sub_id = {$sub_id} AND cam_id = {$id} AND sub_mode = 'anger' AND sub_adr = '{$value}'";
			$con = get_connection();
		    $response = $con->query($query);
		    if($response === false){
		        $error["message"] = "Ошибка запроса в базу данных";
				response($error);
		    }
			break;
			
		case 'tire':
			$query = "DELETE FROM subscribers WHERE sub_id = {$sub_id} AND cam_id = {$id} AND sub_mode = 'tire' AND sub_adr = '{$value}'";
			$con = get_connection();
		    $response = $con->query($query);
		    if($response === false){
		        $error["message"] = "Ошибка запроса в базу данных";
				response($error);
		    }
			break;

		case 'stroke':
			$query = "DELETE FROM subscribers WHERE sub_id = {$sub_id} AND cam_id = {$id} AND sub_mode = 'stroke' AND sub_adr = '{$value}'";
			$con = get_connection();
		    $response = $con->query($query);
		    if($response === false){
		        $error["message"] = "Ошибка запроса в базу данных";
				response($error);
		    }
			break;

		case 'sad':
			$query = "DELETE FROM subscribers WHERE sub_id = {$sub_id} AND cam_id = {$id} AND sub_mode = 'sad' AND sub_adr = '{$value}'";
			$con = get_connection();
		    $response = $con->query($query);
		    if($response === false){
		        $error["message"] = "Ошибка запроса в базу данных";
				response($error);
		    }
			break;

		case 'happy':
			$query = "DELETE FROM subscribers WHERE sub_id = {$sub_id} AND cam_id = {$id} AND sub_mode = 'happy' AND sub_adr = '{$value}'";
			$con = get_connection();
		    $response = $con->query($query);
		    if($response === false){
		        $error["message"] = "Ошибка запроса в базу данных";
				response($error);
		    }
			break;

		default:
			$error["message"] = "Неверные параметры";
			response($error);
			break;
	}

	return "Успех";
}


?>