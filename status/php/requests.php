<?php 

if(isset($_GET["test"])){
	file_put_contents("test.txt", $_POST['request']);
}
#$b64 = file_get_contents("b64_1.txt");

#print_r(py_request("rec_emotions", ['img' => $b64]));

function py_request($action, $data){

	$url = 'http://127.0.0.1:5000/';

	$local_url = $url . $action;

	$options = array(
	    'http' => array(
	        'method'  => 'POST',
	        'content' => "request=" . json_encode($data)
	    )
	);

	$context  = stream_context_create($options);

	$result = file_get_contents($local_url, false, $context);

	if ($result === FALSE) {
		$error = [
			'type' => 'error', 
			'message' => 'Ошибка запроса к нейросети'
		];
		return $error;
	}

	$result = json_decode($result, true);

	$ret = [
		'type' => $result['type'], 
		'message' => $result['message']
	];
	return $ret;
}


function send_requests($urls, $request){
	foreach ($urls as $url) {
	 	$options = array(
		    'http' => array(
		        'method'  => 'POST',
		        'content' => "request=" . json_encode($request)
		    )
		);

		$context  = stream_context_create($options);

		@file_get_contents($url, false, $context);
	}
}


?>
