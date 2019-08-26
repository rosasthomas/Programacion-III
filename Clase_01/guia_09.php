<?php
$lista = array();
$suma = 0;

for($i = 0; $i <= 5; $i++){
    array_push($lista, rand(1,10));
    $suma = $suma + $lista[$i];
}
$suma = $suma / 5;
echo $suma . "<br/>";
if($suma > 6){
    echo "Es mayor a 6";
} 
elseif ($suma == 6) {
    echo "Es igual a 6";
}
else {
    echo "Es menor a 6";
}
?>