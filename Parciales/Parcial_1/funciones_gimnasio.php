<?php
function calcular_promocion($antiguedad_M){
    if ($antiguedad_M >=3 && $antiguedad_M<12)
        {
            $discount = 0.08;
            return $discount;
        }
    else if ($antiguedad_M >=12 && $antiguedad_M<24)
                {
            $discount = 0.12;
            return $discount;
        }
    else if ($antiguedad_M >=24)
                {
            $discount = 0.20;
            return $discount;
        }
    else if ($antiguedad_M <3)
                {
            $discount = 0;
            return $discount;
        }
}

function calcular_seguro_medico($cuota_base){
    return $cuota_base * 0.05;
}

function calcular_cuota_final($cuota_base,$descuento_porcentaje, $seguromedico){
    return $cuota_base - $descuento_porcentaje + $seguromedico;
}


?>