<?php

function vacacionesSiNo($dniTra, $fecha) {
    //CONSULTA PARA ESTA FUNCION
    // SELECT t.dni, v.idVacaciones from trabajador t, vacaciones v where (t.dni=v.Trabajador_dni) and (fechaInicio<='2011-01-13') and (fechaFin>='2011-01-13')
    $resVac = mysql_query('SELECT v.idVacaciones from vacaciones v where (v.Trabajador_dni=\''.$dniTra.'\') and (fechaInicio<=\'' . $fecha . '\') and (fechaFin>=\'' . $fecha . '\')');
    $totVac = mysql_num_rows($resVac);
    if ($totVac == 1) {
        return $vacaciones = true;
    } else {
        return $vacaciones = false;
    }
}

?>
