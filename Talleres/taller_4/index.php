<?php
require_once 'Empresa.php';

echo "<h1>Fase 1: Operación Inicial de la Empresa</h1>";

$miEmpresa = new Empresa("Tecnologías Innovadoras Globales");


$gerenteTI = new Gerente("Laura Pausini", 101, 5000, "Tecnología");
$dev1 = new Desarrollador("Ricardo Arjona", 201, 3000, "PHP");
$dev2 = new Desarrollador("Shakira Mebarak", 202, 3500, "JavaScript");
$gerenteVentas = new Gerente("Juan Pérez", 102, 4500, "Ventas");
$databasedev = new Desarrollador("Ana Gómez", 203, 2800, "PHP");

$miEmpresa->agregarEmpleado($gerenteTI);
$miEmpresa->agregarEmpleado($dev1);
$miEmpresa->agregarEmpleado($dev2);
$miEmpresa->agregarEmpleado($gerenteVentas);
$miEmpresa->agregarEmpleado($databasedev);


$dev1->ExperienciaLaboral(10);
$dev2->ExperienciaLaboral(4);
$databasedev->ExperienciaLaboral(2);



$miEmpresa->listarEmpleados();


$miEmpresa->realizarEvaluaciones();


echo "<h3>Estado después de los aumentos:</h3>";
$miEmpresa->listarEmpleados();


echo "<h3>Asignación de Bonos:</h3>";
$gerenteVentas->asignarBono($databasedev, 500.00);

$miEmpresa->reporteSalarioPromedioxPuesto();
echo "la nomina total de la empresa es: ".$miEmpresa->calcularNominaTotal()."$";
$miEmpresa->cargarDatos("./empresa_data.json");
$miEmpresa->guardarDatos("./empresa_data.json");



