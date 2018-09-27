<?php

$desconto = 31;
$produto = 5000;

$melhorpreco = 0;

$dirpc = "C:\Users\Atendimento BBFofuxo\\";

//Caminho onde estão as imagens de produtos
$path = "$dirpc\Google Drive\Bebê Fofuxo\Produtos\Fotos\Site\\$produto";
$diretorio = dir($path);

$arquivo;

	//Cria a pasta com o nome do produto a ser editado
	if (!file_exists("$dirpc\Desktop\Alteracoes\Exportadas photoshop/$produto")){

		mkdir("$dirpc\Desktop\Alteracoes\Exportadas photoshop/$produto");
		
		echo "Diretório criado <br>";
	
	} else {
	
		echo "Diretório já existe <br>";
}

	//Executa a função aplicarDesconto para todo os arquivos do diretório
	while($arquivo = $diretorio -> read()){

		$cor = substr($arquivo, 3);
	
		aplicarDesconto($desconto, $produto, $arquivo, $path, $dirpc, $melhorpreco);

	}

	$diretorio -> close();

	function aplicarDesconto($desconto, $produto, $arquivo, $caminho, $dirpc, $melhorpreco){

	//Verifica se o arquivo é jpg
	if (substr($arquivo, -3) != 'jpg'){

		echo "<br> Não é uma imagem válida <br>";

	} else {

		$image = $caminho."\\".$arquivo;
		$label = "$dirpc\Desktop\Alteracoes/labels/$desconto.png";
		$labelmp = "$dirpc\Desktop\Alteracoes/labels/melhorpreco.png";

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
 		if (imagejpeg($dst_image, "$dirpc\Desktop\Alteracoes\Exportadas photoshop/$produto/$arquivo", 90) === true){

			echo "<br> Desconto na imagem $arquivo aplicado <br>";

		} else {

			echo "<br> Erro ao salvar imagem <br>";
		}	

		//Limpa a variável da memória
		imagedestroy($dst_image);
	
	}
}

?>