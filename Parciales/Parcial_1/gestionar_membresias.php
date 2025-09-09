<?php 
include "./funciones_gimnasio.php";
$plan=[
"basica" => 80,
"premiun" => 120,
"vip" => 180,
"familiar" => 250,
"corporativa" => 300];

$miembros = [
    "michael jackson" => ["tipo" => "premiun","antiguedad"=>2],
    "dwanye jonhson" => ["tipo" => "corporativa","antiguedad"=>24],
    "tiger woods" => ["tipo" => "familiar","antiguedad"=>30],
    "justin timberlake" => ["tipo" => "vip","antiguedad"=>6],
    "karen beatrix" => ["tipo" => "basica","antiguedad"=>14],
    "carlos burningham" => ["tipo" => "premiun","antiguedad"=>23]
];


foreach($miembros as $check){
    $promo = calcular_promocion($check['antiguedad'])."<br>"; 
echo calcular_cuota_final($plan,$promo,calcular_seguro_medico($check['tipo']));
}
?>