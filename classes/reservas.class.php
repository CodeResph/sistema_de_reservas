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
			$sql = "SELECT * FROM reservas WHERE id_carro = :carro";
			$sql = $this->pdo->prepare($sql);

			$sql->bindValue(":carro", $carro);
			$sql->bindValue(":data_inicio", $data_inicio);
			$sql->bindValue(":data_fim", $data_fim);
			$sql->execute();


	}

}

 ?>