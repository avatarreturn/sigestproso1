<?php

function vacacionesSiNo($dniTra, $fecha) {
    //CONSULTA PARA ESTA FUNCION
    // SELECT t.dni, v.idVacaciones from trabajador t, vacaciones v where (t.dni=v.Trabajador_dni) and (fechaInicio<='2011-01-13') and (fechaFin>='2011-01-13')
    $resVac = mysql_query('SELECT v.idVacaciones from vacaciones v where (v.Trabajador_dni=\'' . $dniTra . '\') and (fechaInicio<=\'' . $fecha . '\') and (fechaFin>=\'' . $fecha . '\')');
    $totVac = mysql_num_rows($resVac);
    if ($totVac == 1) {
        return $vacaciones = true;
    } else {
        return $vacaciones = false;
    }
}

function vacacionesPeriodo($dniTra, $fecha) {
    if (vacacionesSiNo($dniTra, $fecha)) {
        $resVac = mysql_query('SELECT v.fechaInicio, v.fechaFin from vacaciones v where (v.Trabajador_dni=\'' . $dniTra . '\') and (fechaInicio<=\'' . $fecha . '\') and (fechaFin>=\'' . $fecha . '\')');
        $rowVac = mysql_fetch_assoc($resVac);
        return $intervalo = array(fechaInicio => $rowVac['fechaInicio'], fechaFin => $rowVac['fechaFin']);
    }
}

function semanaActual() {
    $dSemana = date(N);
    $semana = date("Y-m-d");
    if ($dSemana != 1) {
        while ($dSemana != 1) {
            $semana = date("Y-m-d", strtotime(date("Y-m-d", strtotime($semana)) . " -1 day"));
            $dSemana = date('N', strtotime($semana));
        }
    }
    return $lunes=$semana;
}
function calculaLunes($fecha){
    $dSemana = date(N);
//    $semana = date("Y-m-d");
    if ($dSemana != 1) {
        while ($dSemana != 1) {
            $fecha = date("Y-m-d", strtotime(date("Y-m-d", strtotime($fecha)) . " -1 day"));
            $dSemana = date('N', strtotime($fecha));
        }
    }
    $can_dias=7;
    return $lunes = date("Y-m-d", strtotime("$fecha + $can_dias days"));
//    return $lunes=$fecha;
}

function sumaDia($fecha,$dia)
{	list($year,$mon,$day) = explode('-',$fecha);
	return date('Y-m-d',mktime(0,0,0,$mon,$day+$dia,$year));		
}

?>
