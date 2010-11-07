<?php
	/**
	* TRATAMENTO DE IMAGENS
	* @author Tiago N. Pinto Silva (tiago@tiagonpsilva.net)	
	* @link git://github.com/tiagonpsilva/scripts_uteis.git
	*
	* @param string	$path		Diretório a ser pesquisado
	* @param int	$executa	Se for passado 1, executa a operação de tratamento
	* @param string	$resize		Percentual de redimensionamento da imagem
	* @param int	$quality	Em uma escala de 0 a 100, indica a qualidade da imagem
	*/
	function trataImagem($path,$executa=0,$resize='90%',$quality=100){	
		# Monta o vetor com os arquivos e diretorios na pasta informada
		$arrConteudo= scandir($path);
		
		# Comando a ser executado no shell
		$comando='mogrify ';		
		$comando.="-resize 90% ";
		$comando.="-quality $quality ";
		
		# Percorre o diretorio
		foreach($arrConteudo as $key=>$nome){		
			$pathNovo=$path."/".$nome;
			
			# Testa se o caminho é um diretorio
			if($nome<>'.' && $nome<>'..' && is_dir($pathNovo)){ 
				print "DIR: $pathNovo \n";				
				trataImagem($pathNovo,$executa,$resize,$quality);
			}
				
			# Testa se o caminho é um arquivo
			else if(is_file($path."/".$nome)) {
				if(strpos(mime_content_type($path."/".$nome),'image/')===0){	
					print "ARQ:". $nome ."\n";			
					if($executa==1){
						$output=exec($comando.$path."/".$nome);
						echo $output;
					}
				}
			}

		}
	
	}
	
	$pathIni='/media/dados/outros/fotos/teste';	
	$tamanhoIni=exec('du -sh '.$pathIni);
	
	#Executa a funcao	
	echo("################################################### \n\n");
	trataImagem($pathIni,1,'90%',80);
	$tamanhoFim=exec('du -sh '.$pathIni);
	echo("\nTAMANHO INI : ".$tamanhoIni."\n");
	echo("TAMANHO FIM : ".$tamanhoFim."\n");					
	echo("################################################### \n");
?>
