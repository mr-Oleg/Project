<!doctype html>
<html lang="ru">

    <head>
        <meta charset="utf-8" />
        <title>Настройка слушателей</title>
        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
		<script src="https://getbootstrap.ru/docs/v4-alpha/dist/js/bootstrap.js"></script>
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
  											<tbody>
												<tr>
													<th scope="row">1</th>
													<th>152.56.88.12:65506</th>
     												<th><button type="button" class="btn btn-danger">Удалить</button></th>
    											</tr>
												<tr>
													<th scope="row">2</th>
													<th>152.56.88.12:65506</th>
     												<th><button type="button" class="btn btn-danger">Удалить</button></th>
    											</tr>
												<tr>
													<th scope="row">3</th>
													<th>152.56.88.12:65506</th>
     												<th><button type="button" class="btn btn-danger">Удалить</button></th>
    											</tr>
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
									<input type="text" class="form-control" placeholder="Введите IP-адрес" aria-label="Recipient's username" aria-describedby="basic-addon2">
									<div class="input-group-append">
										<button class="btn btn-outline-success" type="button" onclick="document.getElementById('myModal').style.display = 'block';">Добавить</button>
									</div>
								</div>
							</div>
							
						</div>
						
					</div>
				
				</div>
				
			</div>
			
		</div>
	
		<div id="myModal" class="modal" tabindex="-1" style="display:none;">
				<div class="modal-dialog modal-sm">
				  	<div class="modal-content">
						<div class="modal-header">
						  <h4 class="modal-title">Уведомление</h4>
						</div>
						<div class="modal-body text-center" id="textmessage">
                            <span>Запись успешно добавлена!</span>
							<button style="margin-top:5%;" class="btn btn-primary" data-dismiss="modal" onclick="document.getElementById('myModal').style.display = 'none';">Отлично! </button>
                        </div>
				  	</div>
				</div>
        </div>
	
	</body>
</html>