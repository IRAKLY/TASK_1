<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="Windows-1251">
	<title>Is Valid card</title>
</head>
<body>
<div>
        <form  method="post">
            <input type="text" placeholder="Введите номер карты" maxlength=16 name="name">
            <button type="submit">Проверить</button>
        </form>
    </div>
<?php 

    try {
        $dbh = new PDO('mysql:dbname=numbersCards;host=localhost', 'root', '');
    } catch (PDOException $e) {
        die($e->getMessage());
    }
    $sth = $dbh->prepare("SELECT * FROM `cards` WHERE `id` = ?");
    $sth->execute(array('4'));
    $array = $sth->fetch(PDO::FETCH_ASSOC);
    print_r($array);


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
    

    

?>

</body>
</html>


