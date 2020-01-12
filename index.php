<?php 

require "config.php";
require "classes/reservas.class.php";
require "classes/carros.class.php";

//mandando a conexao com o banco pelo método construtor contido na 
//variavel $pdo (injeção de dependência)
$reservas = new Reservas($pdo);
$carros = new Carros($pdo);

?>

<h1>Reservas</h1>

<a href="reservar.php">Adicionar Reserva</a>
<br><hr>
<?php 	
$lista = $reservas->getReservas();

foreach ($lista as $item) {
	//formatando a data recebida do banco
	$data1 = date('d/m/Y', strtotime($item['data_inicio']));
	$data2 = date('d/m/Y', strtotime($item['data_fim']));
	echo $item['pessoa'].' reservou o carro '.$item['id_carro'].' entre '.$data1.' e '.$data2.'<br>';
}

 ?>