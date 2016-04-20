<?php
// опишем класс для работы
class My {
function proverka($data) {
  $data = preg_replace("/[^\d\-\*\^\/\:\+]/", '', $data); 
  return $data;  
}

function delduble($str) {
  $str = str_replace("--", "+", $str);  // меняем очевидное, перед заменой дублей	
  $arr = array("/(\+)+/","/(\-)+/","/(\*)+/","/(\/)+/","/(\:)+/","/(\^)+/");
  $str = preg_replace($arr,"$1",$str);
  return $str;
}	
}

// получаем входные данные
$primer=$_GET['PRIMER'];

  $my=new My;
  if ($my->proverka($primer) == '') { $error='Ошибка ввода: В строке нет цифр!';}
  $primer=$my->delduble($primer);
  $oper_count = strlen(preg_replace("/[^\+\-\*\^\/\:]/", '', $primer));
  if ($oper_count<>1) {$error='Ошибка ввода: Введите ОДНУ операцию';}
  $cifr = preg_split("/[\+\-\*\^\/\:]/", $primer);
  $oper = preg_replace("/[^\+\-\*\^\/\:]/", '', $primer);	
	if ($cifr[0]=='' || $cifr[1]=='' ) {$error='Ошибка ввода: Не полный ввод!';}
	if (($oper=="\\" || $oper==":") && $cifr[1]=='0') {$error='Ошибка ввода: Ай яй яй, делить на 0 нельзя!';}
	  if ($error=='') {
	   switch ($oper) {
		case "/": $primer=$cifr[0]/$cifr[1]; break;
		case ":": $primer=$cifr[0]/$cifr[1]; break;	
		case "*": $primer=$cifr[0]*$cifr[1]; break;
		case "^": $primer=pow($cifr[0],$cifr[1]); break;
		case "+": $primer=$cifr[0]+$cifr[1]; break;	 
		case "-": $primer=$cifr[0]-$cifr[1]; break;		
	   }
	 }

// Создаем массив с данными которые хотим отправить json ответом
$data = array(
	'result' => (($error=='')?$primer:$error),
);

//Переводим масив в JSON
$json_data=json_encode($data); 

// Выставляем кодировку и тип контента
header("Content-type: application/json; charset=utf-8");  

//JSONP - делаем JSONP объект
echo $_GET['callback'] . ' (' . $json_data . ');'; 