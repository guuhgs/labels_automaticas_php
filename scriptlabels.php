<?php

$arquivo;

//Abre o arquivo csv e formata corretamente
$handle = fopen("C:\Users\Atendimento BBFofuxo\Desktop\Alteracoes\csvdescontos\produtos.csv", "r");
$csvprodutos = array();
$campo = array();
$count = 1;
	
	while ($linha = fgetcsv($handle, 1000, ";")){

		if (count(array_filter($linha)) > 0) {
			
			if ($count == 1){

				$campo = $linha;

			} else {

				$csvprodutos[] = array_combine($campo, $linha);
			}	

				$count++;

			}
	}

	foreach ($csvprodutos as $key => $value) {
		
		//Tira o caractere % e atribui os valores á variáveis 
		$desconto = substr($value["desconto"], 0,-1);
		$produto = $value["cod"];

		$optmp = strtoupper($value["melhorpreco"]);

			if ($optmp == "SIM"){

				$melhorpreco = 1;
		
			} else {

				$melhorpreco = 0;
			}

		//Caminho onde estão as imagens de produtos
		$path = "C:\Users\Atendimento BBFofuxo\Google Drive\Bebê Fofuxo\Produtos\Fotos\Site\\$produto";
		$diretorio = dir($path);

	//Cria a pasta com o nome do produto a ser editado se ela não existir
	if (!file_exists("C:\Users\Atendimento BBFofuxo\Desktop\Alteracoes\Exportadas photoshop/$produto")){

		mkdir("C:\Users\Atendimento BBFofuxo\Desktop\Alteracoes\Exportadas photoshop/$produto");
		
		echo "<br> Diretório criado <br>";
	
	} else {
	
		echo "<br> Diretório já existe <br>";
	}

	//Executa a função aplicarDesconto para todo os arquivos do diretório
	while($arquivo = $diretorio -> read()){

		$cor = substr($arquivo, 3);
	
		aplicarDesconto($desconto, $produto, $arquivo, $path, $melhorpreco);

		}
	}

	$diretorio -> close();

	function aplicarDesconto($desconto, $produto, $arquivo, $caminho, $melhorpreco){

	//Verifica se o arquivo é jpg
	if (substr($arquivo, -3) != 'jpg'){

		echo "<br> O arquivo $arquivo não é uma imagem válida <br>";

	} else {

		//Atribui os arquivos de imagem á variáveis
		$image = $caminho."\\".$arquivo;
		$label = "C:\Users\Atendimento BBFofuxo\Desktop\Alteracoes/labels/$desconto.png";
		$labelmp = "C:\Users\Atendimento BBFofuxo\Desktop\Alteracoes/labels/melhorpreco.png";

		//Cria as imagens que serão usadas 
		$dst_image = imagecreatefromjpeg($image);
		$src_image = imagecreatefrompng($label);
		$mp_image = imagecreatefrompng($labelmp);

		//Pega informações da imagem com o getimagesize
		list($dst_width, $dst_height, $dst_type, $dst_attr) = getimagesize($image);
		list($src_width, $src_height, $src_type, $src_attr) = getimagesize($label);
		list($mp_width, $mp_height, $mp_type, $mp_attr) = getimagesize($labelmp);

			//Calcula a posição que a label vai ocupar na imagem
			$dst_y = 20;
			$dst_x = ($dst_width - $src_width) - 10;

			$dst_y2 = 255;
			$dst_x2 = ($dst_width - $mp_width) - 10;

		//Copia uma imagem na outra
		imagecopy($dst_image, $src_image, $dst_x, $dst_y, 0, 0, $src_width, $src_height);

		if ($melhorpreco == 1){

			imagecopy($dst_image, $mp_image, $dst_x2, $dst_y2, 0, 0, $mp_width, $mp_height);
		}

		//Salva a imagem em um diretório (Atualmente salva na pasta exportadas photoshop)
 		if (imagejpeg($dst_image, "C:\Users\Atendimento BBFofuxo\Desktop\Alteracoes\Exportadas photoshop/$produto/$arquivo", 90) === true){

			echo "<br> Desconto na imagem $arquivo aplicado <br>";

		} else {

			echo "<br> Erro ao salvar imagem <br>";
		}	

		//Limpa a variável da memória
		imagedestroy($dst_image);
	
	}
}

?>