<?php 

$desconto = 9;
$produto = 312;

$path = "C:\Users\Atendimento BBFofuxo\Google Drive\Bebê Fofuxo\Produtos\Fotos\Site\\$produto";

//Cria a pasta com o nome do produto a ser editado
if (!file_exists("img/$produto")){

	mkdir("img/$produto");
}

//Executa a função aplicarDesconto para todo os arquivos do diretório
$diretorio = dir($path);
 
	while($arquivo = $diretorio -> read()){
	
	$cor = substr($arquivo, 3);
	
	aplicarDesconto($desconto, $produto, $cor, $path);

	}

	$diretorio -> close();

function aplicarDesconto($desconto, $produto, $cor, $caminho){

	//Verifica se o arquivo é jpg
	if (substr($cor, -3) != 'jpg'){

		echo "<br> Não é uma imagem <br>";

	} else {

	$image = $caminho."\\".$produto.$cor;
	$label = "labels/$desconto.png";

	//Cria as imagens que serão usadas 
	$dst_image = imagecreatefromjpeg($image);
	$src_image = imagecreatefrompng($label);

	//Pega informações da imagem com o getimagesize
	list($dst_width, $dst_height, $dst_type, $dst_attr) = getimagesize($image);

		$dst_largura = $dst_width;
		$dst_altura = $dst_height;

	list($src_width, $src_height, $src_type, $src_attr) = getimagesize($label);

		$src_largura = $src_width;
		$src_altura = $src_height;

	//Calcula a posição que a label vai ocupar na imagem
	$dst_y = 20;
	$dst_x = ($dst_largura - $src_largura) - 10;

	//Copia uma imagem na outra
	imagecopy($dst_image, $src_image, $dst_x, $dst_y, 0, 0, $src_largura, $src_altura);

	//Salva a imagem em um diretório
 	if (imagejpeg($dst_image, "img/$produto/$produto". $cor, 90) === true){

		echo "<br> Desconto no arquivo $produto.$cor aplicado <br>";

	} else {

		echo "<br> Erro ao salvar imagem <br>";
}

	//Limpa a variável da memória
	imagedestroy($dst_image);
	
	}
}

?>