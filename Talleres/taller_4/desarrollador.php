<?php

require_once 'Empleado.php';

class Desarrollador extends Empleado {
    private $lenguajePrincipal;
    private $NivelExp;
    private $proyectosAsignados = [];

    public function __construct(string $nombre, int $idEmpleado, float $salarioBase, string $lenguajePrincipal) {
        parent::__construct($nombre, $idEmpleado, $salarioBase);
        $this->lenguajePrincipal = $lenguajePrincipal;
    }


    public function getLenguajePrincipal(): string {
        return $this->lenguajePrincipal;
    }

    public function setLenguajePrincipal(string $lenguaje): void {
        $this->lenguajePrincipal = $lenguaje;
    }
    public function asignarProyecto(string $nombreProyecto): void { $this->proyectosAsignados[] = $nombreProyecto; }
    
        public function getProyectosAsignados(): array {
        return $this->proyectosAsignados;
    }
    public function ExperienciaLaboral(int $anios): void {
        $this->NivelExp=$anios;
        echo "El desarrollador ".$this->getnombre()." tiene : ".$this->NivelExp." años de experiencia laboral.<br>";
    }

    public function programar(): string {
        return "El desarrollador ".$this->getnombre()." está programando en {$this->lenguajePrincipal}.";
    }
    public function calcularSalarioAnual(): float {
        $salarioBaseAnual = parent::calcularSalarioAnual();
        $bono = $salarioBaseAnual * 0.10; 
        return $salarioBaseAnual + $bono;
    }
}