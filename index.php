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



	function checkNumberCard($cardNumber){

        $numLength = strlen($cardNumber);           // Длина номера
        $amount = 0;                                // Сумма чисел
        $isSecond = false;                          // Второе число

        echo "Длина номера карты = ".$numLength."<br>";
      
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

    function checkPrefixCard($cardNumber){

        $prefix = substr($cardNumber, 0, 2);

        echo "Префикс = ".$prefix."<br>";
        switch ($prefix) {
            case '14': 
            case '81': 
            case '99':
                printf("Это карта Даронь кредит!<br>");
                break;
            case '22': 
            case '23': 
            case '27':
                printf("Это карта MasterCard кредит!<br>");
                break;

            
            default:
                printf("Это карта не поддерживается!<br>");
                break;
        }
    }

    $cardNumber = htmlspecialchars($_POST['name']);
    if ($cardNumber == '') {
        echo "Введите номер карты";
    } else {
        echo "Ваш номер карты: ".$cardNumber."<br>";
        checkPrefixCard($cardNumber);
        
        if (checkNumberCard($cardNumber)) {
            printf("<h3 color='green'>Корректный номер карты</h3>");
        } else{
            printf("<h3 color='red'>Неверный номер карты</h3>");
        }
    }
    

    

?>

</body>
</html>


