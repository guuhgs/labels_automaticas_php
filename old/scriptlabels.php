<?php 

$desconto = 8;
$produto = 312;
$cor = "vermelho";

AplicarDesconto($desconto, $produto, $cor);

function AplicarDesconto($desconto, $produto, $cor){

	$image = "C:\Users\Atendimento BBFofuxo\Google Drive\Bebê Fofuxo\Produtos\Fotos\Site\\$produto\\$produto"."_"."$cor.jpg";
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

	//Monta um cabeçalho personalizado para o pacote HTTP (Desativar para conseguir visualizar mensagens de erro)
	//header("Content-Type: image/jpg"); 

	//Salva a imagem em um diretório
 	if (imagejpeg($dst_image, "img/$produto"."_"."$cor.jpg", 90) === true){

		echo "Imagem salva";

	} else {

		echo "<br> Erro ao salvar imagem <br>";
}

	//Limpa a variável da memória
	imagedestroy($dst_image);
}

?>