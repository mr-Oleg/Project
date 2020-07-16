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


include("py_request.php");
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
	
	$con = get_connection();
	$query = "SELECT * FROM recognize WHERE rec_id = {$id}";
	$response = $con->query($query);
	if($response === false){
        $error["message"] = "Ошибка запроса в базу данных";
		response($error);
    }
    $recs = $response->fetch(PDO::FETCH_ASSOC);

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
				if($anger_value > 0.7) $anger = 3;
				else if($anger_value > 0.3) $anger = 2;
				else if($anger_value >= 0) $anger = 1;
				else $anger = 0;
			}

			if($recs["rec_sadness"]==1){
				$sadness_value = $emotions[1];
				if($sadness_value > 0.5) $sadness = 2;
				else if($sadness_value > 0) $sadness = 1;
				else $sadness = 0;
			}

			if($recs["rec_happiness"]==1){
				$happiness_value = $emotions[2];
				if($happiness_value > 0.5) $happiness = 1;
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
