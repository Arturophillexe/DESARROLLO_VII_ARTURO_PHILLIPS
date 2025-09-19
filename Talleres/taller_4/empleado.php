<?php
require_once 'evaluar.php';
class empleado implements Evaluar{
private $nombre;
private $id;
private $salario;

public function __construct($nombre,$id,$salario){
    $this->setnombre($nombre);
    $this->setid($id);
    $this->setsalario($salario);
}

public function getnombre(){return $this->nombre;}
public function setnombre($nombre){$this->nombre = trim($nombre);}

public function getid(){return $this->id;}
public function setid($id){$this->id = trim($id);}

public function getsalario(){return $this->salario;}
public function setsalario($salario){if ($salario > 0) {$this->salario=floatval($salario);}}
    public function aplicarAumento(float $porcentajeAumento): void {
        $aumento = $this->salario * $porcentajeAumento;
        $this->setSalario($this->salario + $aumento);
    }
public function evaluarDesempenio(){if ($this instanceof Desarrollador) {
            $numProyectos = count($this->getProyectosAsignados()); // Usa el getter de Desarrollador
            if ($numProyectos >= 2) {
                $this->aplicarAumento(0.07); // Aumento del 7%
                return "Evaluación de {$this->getNombre()} (Desarrollador): Excelente. {$numProyectos} proyectos completados. Se aplicó aumento.";
            } else {
                $this->aplicarAumento(0.03); // Aumento del 3%
                return "Evaluación de {$this->getNombre()} (Desarrollador): Cumple expectativas. Se aplicó aumento estándar.";
            }
        }
        // Verifica si el objeto actual es una instancia de la clase Gerente
        elseif ($this instanceof Gerente) {
            $tamanoEquipo = count($this->getEquipoACargo()); // Usa el getter de Gerente
            if ($tamanoEquipo > 5) {
                $this->aplicarAumento(0.10); // Aumento del 10%
                return "Evaluación de {$this->getNombre()} (Gerente): Liderazgo sobresaliente. Gestiona a {$tamanoEquipo} personas. Se aplicó aumento.";
            } else {
                $this->aplicarAumento(0.05); // Aumento del 5%
                return "Evaluación de {$this->getNombre()} (Gerente): Sólido liderazgo. Se aplicó aumento estándar.";
            }
        }
        // Para cualquier otro tipo de empleado que no sea Desarrollador o Gerente
        else {
            $this->aplicarAumento(0.02); // Aumento base del 2%
            return "Evaluación de {$this->getNombre()} (Empleado): Evaluación estándar completada. Se aplicó aumento base.";
        }}

    public function calcularSalarioAnual(): float {
        return $this->salario * 12;
    }
}






?>