<?php

require_once 'Empleado.php';

class Gerente extends Empleado {
    private $departamento;
    private $equipoACargo = [];
    private $bonusMethod;

    public function __construct(string $nombre, int $idEmpleado, float $salarioBase, string $departamento) {
   
        parent::__construct($nombre, $idEmpleado, $salarioBase);
        $this->departamento = $departamento;
    }

    public function getDepartamento(): string {
        return $this->departamento;
    }

    public function agregarMiembroEquipo(Empleado $empleado): void {
        $this->equipoACargo[] = $empleado->getNombre();
        echo "{$empleado->getNombre()} ha sido añadido al equipo del departamento de {$this->departamento}.<br>";
    }

    public function gestionarEquipo(): string {
        $miembros = implode(', ', $this->equipoACargo);
        return "El gerente ".$this->getnombre()." está gestionando el departamento de {$this->departamento} con los siguientes miembros: {$miembros}.";
    }
        public function getEquipoACargo(): array {
        return $this->equipoACargo;
    }


    public function calcularSalarioAnual(): float {
        $salarioBaseAnual = parent::calcularSalarioAnual();
        $bonoGestion = $salarioBaseAnual * 0.25; 
        return $salarioBaseAnual + $bonoGestion;
    }       
    public function asignarBono(Empleado $empleado, float $montoBono): void {
        if ($montoBono <= 0) {
            echo "<p>El monto del bono debe ser positivo.</p>";
            return;
        }
    
        
        $salarioActual = $empleado->getSalario();
        $empleado->setSalario($salarioActual + $montoBono);
        
        echo "<p><b>{$this->getNombre()}</b> ha asignado un bono de <b>{$montoBono} $</b> a <b>{$empleado->getNombre()}</b>.</p>";
    }
}