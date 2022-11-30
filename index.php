<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="Windows-1251">
	<title>Is Valid card</title>
</head>
<body>
    <header class="navbar navbar-inverse navbar-fixed-top header"> </header>


    <div class="content">
		<div class="row">
			<div class="col-sm-5">
				<div class="content-titleForm">
					<h2 class="content-titleForm__title"><span class="title" data-type="1">Проверка номера карты!</span></h2>
				</div>
				<form class="form-horizontal content-form" id="form" method="post">
					<div class="form-group row">
						<label for="author" class="col-sm-3 control-label">Введите номер карты</label>
						<div class="col-sm-9">
							<input type="text" maxlength=16 name="name" class="form-control" id="author" placeholder="Введите номер карты" required="required">
						</div>
					</div>

					<div class="form-group row">
						<div class="col-sm-offset-3 col-sm-9">
							<button type="submit" class="btn btn-success" id="addBookForm">Проверить</button>
						</div>
					</div>
				</form>
			</div>
			<div class="col-sm-7">
				<div class="list-items" id="list-books"></div>
			</div>
		</div>
	</div>
    
    <footer class="navbar navbar-inverse navbar-fixed-bottom footer"></footer>
	<link rel="stylesheet" href="css/style.css">
<?php 
        
    try {
        $dbh = new PDO('mysql:dbname=numbersCards;host=localhost', 'root', '');
    } catch (PDOException $e) {
        die($e->getMessage());
    }


    function buildingTable($rows, $cols){
        
        echo '<table border="1">';
        
        for ($tr=1; $tr<=$rows; $tr++){ 
            echo '<tr>';
            for ($td=1; $td<=$cols; $td++){ 
                echo '<td>'. $tr*$td .'</td>';
            }
            echo '</tr>';
        }
        
        echo '</table>';
    }


	function checkNumberCard($cardNumber){

        $numLength = strlen($cardNumber);           // Длина номера
        $amount = 0;                                // Сумма чисел
        $isSecond = false;                          // Второе число

        echo "Длина номера карты = ".$numLength."<br>";
      
        $patternDaron = "/^([1][4]|[8][1]|[9][9])/";
        $patternMasterCard = "/^[2][2-7][0-9][0-9]/";
        $patternMaestro = "/^[0-1][0-3][0-9][0-9]/";

        if (preg_match($patternMasterCard, $cardNumber) && $numLength == 16) {
            echo "Это карта MasterCard кредит!<br>";
        } elseif (preg_match($patternMaestro, $cardNumber) && $numLength == 16) {
            echo "Это карта Maestro кредит!<br>";
        } elseif (preg_match($patternDaron, $cardNumber) && $numLength == 14) {
            echo "Это карта Даронь кредит!<br>";
        } else {
            echo "Карта с таким номером не поддерживается!<br>";
        } 

        for ($i = 0; $i <= $numLength - 1; $i++) {
 

            $value = $cardNumber[$i];               // Текущее значение

            if ($isSecond == true) {
                $value = $value * 2;
                $amount += floor($value / 10);
                $amount += $value % 10;
            } else {
                $amount += $value;
            }
            $isSecond = !$isSecond;
        }
        return ($amount % 10 == 0);
       

    }

    $cardNumber = htmlspecialchars($_POST['name']);
    if ($cardNumber == '') {
        echo "Введите номер карты";
    } else { 
        echo "Ваш номер карты: ".$cardNumber."<br>";
        
        if (checkNumberCard($cardNumber)) {
            printf("<h3 color='green'>Корректный номер карты</h3>");
        } else{
            printf("<h3 color='red'>Неверный номер карты</h3>");
        }
    }
    
    buildingTable(5,5);
    $sth = $dbh->prepare("SELECT * FROM `cards` WHERE `id` = ?");
    for ($i=1; $i <=4 ; $i++) { 
            $sth->execute(array($i));
            $array = $sth->fetch(PDO::FETCH_ASSOC);
            echo "<br>";
            print_r($array);
            echo "<br>";
    }

?>

</body>
</html>


