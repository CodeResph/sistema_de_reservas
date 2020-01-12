<?php 

require "config.php";
require "classes/reservas.class.php";
require "classes/carros.class.php";

//mandando a conexao com o banco pelo método construtor contido na 
//variavel $pdo (injeção de dependência)
$reservas = new Reservas($pdo);
$carros = new Carros($pdo);

//Verificando se o valor passado pelo metodo post do campo 
//com o name carro tem algum valor ou se esta vazio...
if(!empty($_POST['carro'])) {
	$carro = addslashes($_POST['carro']);
	$data_inicio = explode('/', addslashes($_POST['data_inicio']));
	$data_fim = explode('/', addslashes($_POST['data_fim']));
	$pessoa = addslashes($_POST['pessoa']);

	//Reordenando a data
	$data_inicio = $data_inicio[2].'-'.$data_inicio[1].'-'.$data_inicio[0];
	$data_fim = $data_fim[2].'-'.$data_fim[1].'-'.$data_fim[0];

	//Verificação antes de efetuar a reserva
	if ($reservas->verificarDisponibilidade($carro, $data_inicio, $data_fim)) {
		$reservas->reservar($carro, $data_inicio, $data_fim, $pessoa);
		//Após inserir a reserva, redireciona para a pag inicial
		header("Location: index.php");
		exit;
	} else {
		echo "Este carro já está alugado neste período.";
	}
}

?>
<h1>Adicionar Reserva</h1>

<form method="POST">
	Carro:<br>
	<select name="carro" id="carro">
		<?php 	
			$lista = $carros->getCarros();

			foreach ($lista as $cars) {
			?>
			<option value="<?php echo $cars['id']; ?>">
				<?php echo $cars['nome']; ?>
			</option>
			<?php	
			}
		?>
	</select><br><br>	

	Data de inicio:<br>
	<input type="text" name="data_inicio"><br><br>	

	Data de fim:<br>
	<input type="text" name="data_fim"><br><br>	

	Nome:<br>
	<input type="text" name="nome"><br><br>	

	<input type="submit" value="Reservar">

</form>