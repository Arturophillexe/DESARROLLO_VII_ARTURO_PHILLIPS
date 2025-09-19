<?php

require_once 'Empleado.php';
require_once 'Desarrollador.php';
require_once 'Gerente.php';
require_once 'Evaluar.php';

class Empresa {
    private $nombre;
    private $listaEmpleados = [];

    public function __construct(string $nombre) {
        $this->nombre = $nombre;
    }
    public function getnombre(){return $this->nombre;}
    public function setnombre($nombre){$this->nombre = trim($nombre);}


    public function agregarEmpleado(Empleado $empleado): void {
        $this->listaEmpleados[] = $empleado;
        echo "{$empleado->getNombre()} ha sido contratado.<br>";
    }


    public function listarEmpleados(): void {
        echo "<h2>Lista de Empleados de {$this->nombre}</h2>";
        echo "<ul>";
        foreach ($this->listaEmpleados as $empleado) {
            echo "<li><b>ID:</b> {$empleado->getId()}, <b>Nombre:</b> {$empleado->getNombre()}, <b>Puesto:</b> " . get_class($empleado) . ", <b>Salario Base:</b> {$empleado->getSalario()} $</li>";
        }
        echo "</ul>";
    }


    public function calcularNominaTotal(): float {
        $nominaTotal = 0;
        foreach ($this->listaEmpleados as $empleado) {
            $nominaTotal += $empleado->getSalario();
        }
        return $nominaTotal;
    }

        public function reporteSalarioPromedioxPuesto(): void {
        echo "<h2>Reporte: Salario Promedio por Puesto</h2>";
        $salarios = [];
        $contador = [];

        foreach ($this->listaEmpleados as $empleado) {
            $puesto = get_class($empleado);
            $salarios[$puesto] = ($salarios[$puesto] ?? 0) + $empleado->getSalario();
            $contador[$puesto] = ($contador[$puesto] ?? 0) + 1;
        }

        echo "<ul>";
        foreach ($salarios as $puesto => $total) {
            $promedio = $total / $contador[$puesto];
            echo "<li><b>{$puesto}:</b> Salario promedio de " . number_format($promedio, 2) . " $ (basado en {$contador[$puesto]} empleado(s))</li>";
        }
    }

    public function realizarEvaluaciones(): void {
        echo "<h2>Evaluaciones de Desempeño</h2>";
        echo "<ul>";
        foreach ($this->listaEmpleados as $empleado) {
            if ($empleado instanceof Evaluar) {
                echo "<li>" . $empleado->evaluarDesempenio() . "</li>";
            }
        }
        echo "</ul>";
    }

    public function guardarDatos(string $archivo): void {
        $datosParaGuardar = [];
        foreach ($this->listaEmpleados as $empleado) {
            $datosParaGuardar[] = [
                'clase' => get_class($empleado),
                'datos' => $empleado
            ];
        }

        $json = json_encode($datosParaGuardar, JSON_PRETTY_PRINT);
        file_put_contents($archivo, $json);
        echo "<b><p>Información de la empresa guardada en '{$archivo}'.</p></b>";
    }

    public function cargarDatos(string $archivo): void {
        if (!file_exists($archivo)) return;

        $json = file_get_contents($archivo);
        $datosGuardados = json_decode($json, true);
        
        $this->listaEmpleados = [];
        foreach ($datosGuardados as $item) {
            $clase = $item['clase'];
            $datos = $item['datos'];
            
            if ($clase === 'Desarrollador') {
                $empleado = new Desarrollador($datos['nombre'], $datos['idEmpleado'], $datos['salarioBase'], $datos['lenguajePrincipal']);
            } elseif ($clase === 'Gerente') {
                $empleado = new Gerente($datos['nombre'], $datos['idEmpleado'], $datos['salarioBase'], $datos['departamento']);
            }
            $this->listaEmpleados[] = $empleado;
        }
        echo "<b><p>Información de la empresa cargada desde '{$archivo}'.</p></b>";
    }

}
