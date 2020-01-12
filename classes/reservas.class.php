<?php 	
	
class Reservas {

	private $pdo;

	public function __construct($pdo){
			$this->pdo = $pdo;
	}

	public function getReservas(){
		$array = array();

		$sql = "SELECT * FROM reservas";
		$sql = $this->pdo->query($sql);

		if ($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}
	//Método responsável pela verificação de disponibilidade dos carros para aluguel
	public function verificarDisponibilidade($carro, $data_inicio, $data_fim) {
		//[Lógica de verificação do período]
		//A data informada na reserva não pode estar dentre a data de qualquer reserva...
		//somente reservar se a data for maior que a data final da reserva do carro...
			$sql = "SELECT 
			* FROM reservas 
			WHERE id_carro = :carro
			AND ( NOT ( data_inicio > :data_fim OR data_fim < :data_inicio) )";
			$sql = $this->pdo->prepare($sql);

			$sql->bindValue(":carro", $carro);
			$sql->bindValue(":data_inicio", $data_inicio);
			$sql->bindValue(":data_fim", $data_fim);
			$sql->execute();

			//Se ouver algum resultado não pode efetuar a reserva no período informado
			if($sql->rowCount() > 0) {
					return false;
			} else {
				return true;
			}
	}

	public function reservar($carro, $data_inicio, $data_fim, $pessoa) {
				$sql = "INSERT INTO reservas (
				  id_carro, 
				  data_inicio, 
				  data_fim, 
				  pessoa,
				) VALUES (
				  :carro, 
				  :data_inicio,
				  :data_fim,
				  :pessoa
				)";
			$sql = $this->pdo->prepare($sql);
			$sql->bindValue(":carro", $carro);
			$sql->bindValue(":data_inicio", $data_inicio);
			$sql->bindValue(":data_fim", $data_fim);
			$sql->bindValue(":pessoa", $pessoa); 
			$sql->execute();
	}
}

 ?>