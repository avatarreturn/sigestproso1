<?php

$dni = $_GET["dni"];
$fechaInicio = $_GET["fechaI"];
$fechaFin = $_GET["fechaF"];
$informe = "";

include_once("../Utiles/funciones.php");

include_once ('../Persistencia/conexion.php');
$conexion = new conexion();


/////////////////Esta es la consulta que tengo que poner////////////////////////////
//
//
//SELECT t.dni, t.nombre, t.apellidos, i.idInformeTareas, ta.idTareaPersonal, ta.horas, c.descripcion, p.nombre proyecto
//        FROM trabajador t, informetareas i, tareapersonal ta, catalogotareas c, actividad a, iteracion it, fase f, proyecto p
//        WHERE (i.semana<='2011-01-10') AND (i.semana>='2001-12-15')
//              AND (t.dni=i.Trabajador_dni)
//              AND (ta.CatalogoTareas_idTareaCatalogo=c.idTareaCatalogo)
//              AND (i.idInformeTareas=ta.InformeTareas_idInformeTareas)
//              AND (i.Actividad_idActividad=a.idActividad)
//              AND (a.Iteracion_idIteracion=it.idIteracion)
//              AND (it.Fase_idFase=f.idFase)
//              AND (f.Proyecto_idProyecto=p.idProyecto)
//        ORDER BY t.nombre
//

$result = mysql_query('SELECT t.dni, t.nombre, t.apellidos, i.idInformeTareas, ta.idTareaPersonal, ta.horas, c.descripcion, p.nombre proyecto FROM trabajador t, informetareas i, tareapersonal ta, catalogotareas c, actividad a, iteracion it, fase f, proyecto p where (t.dni=\'' . $dni . '\') AND (i.semana>=\'' . $fechaInicio . '\') AND (i.semana<=\'' . $fechaFin . '\') AND (t.dni=i.Trabajador_dni) AND (ta.CatalogoTareas_idTareaCatalogo=c.idTareaCatalogo) AND (i.idInformeTareas=ta.InformeTareas_idInformeTareas) AND (i.Actividad_idActividad=a.idActividad) AND (a.Iteracion_idIteracion=it.idIteracion) AND (it.Fase_idFase=f.idFase) AND (f.Proyecto_idProyecto=p.idProyecto) ORDER BY t.nombre;');
$totTareas = mysql_num_rows($result);
$horas = 0;
$proyAnterior = "";
$arrayProy;
$cont = 0;
if ($totTareas > 0) {

    while ($rowEmp = mysql_fetch_assoc($result)) {
        $nombre = $rowEmp['nombre'];
        $apellidos = $rowEmp['apellidos'];
        $horas = $horas + $rowEmp['horas'];
        $tabla[$cont] = $rowEmp;

        if ($rowEmp['proyecto'] != $proyAnterior) {
            $arrayProy[$rowEmp['proyecto']] = 0;
            $proyAnterior = $rowEmp['proyecto'];
        }
        $cont++;
    }
    $informe = '<a href="#">' . $nombre . ' ' . $apellidos . '&nbsp;&nbsp;&nbsp;&nbsp;</td><td>' . $dni . "<br/></a>";

//////////////////////////////////calculo de los periodos de vacaciones dentro del intrevalo///////////////////////////

///////////////cosulta para las vacaciones
//SELECT s.fechaInicio, s.fechaFin
//FROM (select `fechaInicio`, `fechaFin` from vacaciones where (`Trabajador_dni`='72262662H')) s
//WHERE (fechaInicio BETWEEN '2011-01-02'
//      AND '2011-01-23')
//      OR (fechaFin BETWEEN '2011-01-02'
//      AND '2011-01-23')

    $sql="SELECT s.fechaInicio, s.fechaFin FROM (select `fechaInicio`, `fechaFin` from vacaciones where (`Trabajador_dni`='".$dni."')) s WHERE (fechaInicio BETWEEN '".$fechaInicio."' AND '".$fechaFin."') OR (fechaFin BETWEEN '".$fechaInicio."' AND '".$fechaFin."');";
    $resVac = mysql_query($sql);
    $totVac = mysql_num_rows($resVac);
    if ($totVac > 0) {
        $informe=$informe."<table><tr><td><a><label>Periodos de vacaciones durante este intervalo:</label></a></td></tr>";
        while ($rowInf = mysql_fetch_assoc($resVac)) {
            $informe=$informe."<tr><td><label>Desde el ".$rowInf['fechaInicio']." hasta el ".$rowInf['fechaFin']."</label></td></tr>";
        }
        $informe=$informe."</table><br/>";
    }else{

    }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




/////////////////////////////horas por proyecto y semana (una linea por cada informe)////////////////////////////////////////77
//      SELECT i.semana, ta.horas, p.nombre
//      FROM tareapersonal ta, informetareas i, actividad a, iteracion it, fase f, proyecto p
//      WHERE (i.idInformeTareas=ta.InformeTareas_idInformeTareas)
//          AND (i.Actividad_idActividad=a.idActividad)
//          AND (a.Iteracion_idIteracion=it.idIteracion)
//          AND (it.Fase_idFase=f.idFase)
//          AND (f.Proyecto_idProyecto=p.idProyecto)
//          AND (i.Trabajador_dni='46547668R')
//          AND (i.semana<='2011-01-18')
//          AND (i.semana>='2011-01-02')
//      ORDER BY p.nombre

    $sql="SELECT i.semana, ta.horas, p.nombre proyecto FROM tareapersonal ta, informetareas i, actividad a, iteracion it, fase f, proyecto p WHERE (i.idInformeTareas=ta.InformeTareas_idInformeTareas) AND (i.Actividad_idActividad=a.idActividad) AND (a.Iteracion_idIteracion=it.idIteracion) AND (it.Fase_idFase=f.idFase) AND (f.Proyecto_idProyecto=p.idProyecto) AND (i.Trabajador_dni='".$dni."') AND (i.semana<='".$fechaFin."') AND (i.semana>='".$fechaInicio."') ORDER BY i.semana";

    $resInf = mysql_query($sql);
    $totInf = mysql_num_rows($resInf);
    $cont = 1;
    $semanaAnterior = "";
    $arraySemanas[] = "";
    $proyAnterior = "";
    $arrayProy;
    $sumaHoras = 0;
    $contS[] = 0;   //Array que almacena el numero de veces que aparece cada semana
    if ($totInf > 0) {
        while ($rowInf = mysql_fetch_assoc($resInf)) {
            $tabInf[$cont] = $rowInf;
            if ($rowInf['semana'] != $semanaAnterior) {
                array_push($contS, 1); // añado un elemento más al array de contadores por cada semana distinto que aparezca
                array_push($arraySemanas, $rowInf['semana']); // añado un elemento más al array de semanas por cada semana distinta que aparezca
                $semanaAnterior = $rowInf['semana'];
            } else {
                $contS[count($contS) - 1]++;            // sumo uno en el elemento correspondiente del array de contadores
            }
            if ($rowInf['proyecto'] != $proyAnterior) {
                $arrayProy[$rowInf['proyecto']] = 0;
                $proyAnterior = $rowInf['proyecto'];
            }
            $cont++;
        }
        $cont = 0;
        $informe = $informe . "<a><label>Horas trabajadas por semana y proyecto:</label></a>";
        for ($i = 1; $i < count($contS); $i++) {    //aqui empiezo a imprimir los resultados
            $sumaHoras = 0;
            $semana = $tabInf[$i]['semana'];

            $arrayProyCopia = $arrayProy; //Utilizo una copia del original por que el foreach se lia con los punteros internos del array

            for ($j = $contS[$i]; $j >= 1; $j--) {
                $cont++;
                $semana = $tabInf[$cont]['semana'];
                $sumaHoras = $sumaHoras + $tabInf[$cont]['horas'];
                $arrayProyCopia[$tabInf[$cont]['proyecto']] = $arrayProyCopia[$tabInf[$cont]['proyecto']] + $tabInf[$cont]['horas'];
            }

            $informe = $informe . "<table>";
            foreach ($arrayProyCopia as $proy => $horasS) {
                    if ($horasS != 0) {
                        $informe = $informe . "<tr><td><label>Semana: " . $semana . "</label></td><td><label>&nbsp;&nbsp;&nbsp;&nbsp;Proyecto: " . $proy . "</label></td><td><label>&nbsp;&nbsp;&nbsp;&nbsp;Horas: " . $horasS . "</label></td></tr>";
                    }
                }
                $informe = $informe."</table>";
        }
    } else {
        $informe = $informe . "<label>No hay informes de tareas para este periodo y este </label>";
            //hay que defir el else**********************************
    }


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    for ($i = 0; $i < count($tabla); $i++) {
        $arrayProy[$tabla[$i]['proyecto']] = $arrayProy[$tabla[$i]['proyecto']] + $tabla[$i]['horas'];
    }

    $arrayProyCopia = $arrayProy;

    $informe = $informe . "<table>";
    foreach ($arrayProyCopia as $proy => $horasP) {
        if ($horasP != 0) {
            //consulta para la participacion en el proyecto
            $resPar = mysql_query('SELECT porcentaje  FROM trabajadorproyecto WHERE Trabajador_dni = \'' . $dni . '\' AND Proyecto_idProyecto=(select idProyecto from proyecto where nombre=\'' . $proy . '\')');
            $rowPar = mysql_fetch_assoc($resPar);
            //fin consulta participacion
            $informe = $informe . "<tr><td><a href='#'><label>Proyecto: " . $proy . "</label></a></td><td><a href='#'><label>&nbsp;&nbsp;&nbsp;&nbsp;Participaci&oacute;n: " . $rowPar[porcentaje] . "%<label></a></td><td><a href='#'><label>&nbsp;&nbsp;&nbsp;&nbsp;Horas: " . $horasP . "</label></a></td></tr>";
        }
    }
    $informe = $informe . '<a href="#"></table><label>Horas trabajadas durante este periodo: ' . $horas . '</label></a>';
} else {
    $result = mysql_query('select nombre, apellidos from trabajador where (dni=\'' . $dni . '\')');
    $rowEmp = mysql_fetch_array($result);
    $nombre = $rowEmp['nombre'];
    $apellidos = $rowEmp['apellidos'];

    $informe = "<div class='centercontentleft'><a href='#'>" . $nombre . " " . $apellidos . "&nbsp;&nbsp;&nbsp;&nbsp;" . $dni . "<br/>Sin informacion para este intervalo</a></div>";
}


echo $informe;
?>
