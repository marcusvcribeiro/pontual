<?php
set_time_limit(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {


	public function index()
	{
		$this->load->model('cadastro', 'ObjCadastro');
        $arquivosAdicional01 =  $this->ObjCadastro->selecionarConfiguracao(1);
		$dados =  array('arquivosAdicional01'=>$arquivosAdicional01);
		$this->load->view('welcome_message', $dados);
	}
	
	public function index2()
	{

		$parser = new \Smalot\PdfParser\Parser();
		$pdf    = $parser->parseFile('arquivos/pdf/div/boleto_1.pdf');
		$text = $pdf->getText();
		echo $text;

		echo strpos($text,"PAGADORA - L001");
	}
	
	
	public function enviarEmail($id)
	{
		

	
	$this->load->model('cadastro', 'ObjCadastro');
    $cadastros =  $this->ObjCadastro->consultarRegistros($id);
	foreach($cadastros as $r)
		{
			
			
			$texto =  $this->ObjCadastro->consultarRegistrosTextos($r->codExterno);
			foreach($texto as $t)
			{
				$arquivo = $t ->arquivo;
			
			//echo $arquivo;
			
			/*if(count($texto)>1)
				echo '<span style="color:#AC0002">[ '. count($texto).' ] '.$r->nome. ' - '.$r->email.'('.$r->codExterno.')<br></span>';
			else if(count($texto)==0)
				echo '<span style="color:#046700">[ '. count($texto).' ] '.$r->nome. ' - '.$r->email.'('.$r->codExterno.')<br></span>';
			else*/
				//echo '[ '. count($texto).' ] '.$r->nome. ' - '.$r->email.'('.$r->codExterno.')<br>';
				
				    $this->load->library('email');
					$this->email->set_newline("\r\n");
					$this->email->from('pontualcontabil2@gmail.com','Pontual');
					$this->email->to($r->email , $r->nome );//$r->email //anacrissil@outlook.com 
					//$this->email->subject('Boleto Alphaville I Ref. 12/2016'); 
					
					
					
					
					
					$arquivosAdicional01 =  $this->ObjCadastro->selecionarConfiguracao(1);

					
					
					
					  foreach($arquivosAdicional01 as $t)
						{
							if($t ->tipoEnvio == 1)
							{
								$tipoEnvio = $t ->tipoEnvio;
								$extension = pathinfo("arquivos/arquivoAnexo/".$t ->arquivoNome);
								if($extension['extension']<>'pdf')
										$coteudoA =  '<img src="'.base_url().'/arquivos/arquivoAnexo/'.$t ->arquivoNome.'"  style="width:100%"><br><br>';           
										if($t ->arquivoNome)	
										$this->email->attach("arquivos/arquivoAnexo/".$t ->arquivoNome, 'attachment');

								
							}
							else
							{ 
							
							  if($t ->arquivoNome)	
							  $this->email->attach("arquivos/arquivoAnexo/".$t ->arquivoNome, 'attachment');
							}
							
							
						
						$this->email->subject($t ->assunto); 	
							
							
						}
									
					$dadosCampos = array('nome'=>$r->nome,'lote'=>$r->codExterno,'coteudoA'=>$coteudoA);
					
					$conteudo = $this->parser->parse('mensagemEmail',$dadosCampos, true);
					$this->email->message($conteudo);
					//$this->email->attach("http://navicat.com.br/composer/".$arquivo);
					//$arquivo
					//$this->email->attach('arquivos/01.pdf');
					
				 	$this->email->attach($arquivo, 'attachment', 'boleto.pdf');
					$this->email->set_newline("\r\n");
            		$this->email->set_crlf("\r\n");
		  		
						
						//echo $conteudo;
						
						
					if($arquivo){	
					//$si =$this->email->send() $this->email->send()
					if($si =$this->email->send())
					{
						echo '<span style="color:#046700">ENVIADO [ '. count($texto).' ] </span>';						
					     $cadastros =  $this->ObjCadastro->mudarStatus(array('status'=>1),$r->id);
						
					}else{
						echo '<span style="color:#AC0002">FALHA NO ENVIO [ '. count($texto).' ]</span>';	
						show_error($this->email->print_debugger());
					//print_debugger();					
					}
					}else{
						echo '<span style="color:#AC0002">Sem Anexo</span>';
						
						}
					
				
				
			}
			
			if(count($texto)==0){
				
				$cadastros =  $this->ObjCadastro->mudarStatus(array('status'=>2),$r->id);
				echo '<span style="color:#AC0002">Sem Anexo</span>';
			}
		}
			
		
	}
	
	
	public function dispararEmails()
	{
		
		echo  $this->parser->parse('enviar01',array(), TRUE);
		
		$this->load->model('cadastro', 'ObjCadastro');
		$cadastros =  $this->ObjCadastro->consultarRegistros();
		$h = 1;
		foreach($cadastros as $r)
		{
			//$this->enviarEmail($r->id);
			
			echo '<div class="divlinha" >'. $r->nome. ' - '.$r->email.'('.$r->codExterno.') <span id="carregando'.$r->id.'" style="float:right;"> </span></div>';
			
			
			$rs = '';
			if(count($cadastros) == $h)
			$rs = 'window.document.location.href="'.base_url().'home/dispararEmails"';
			
			$h = $h +1;
			
			$scripts .= '
			
			
			
			$.fn.enviarEmail'.$r->id.' = function(idcod)
			{ 
			
			  
			
			    $( "#carregando" ).slideUp( 300 ).delay( 2000 ).fadeIn( 400 );
  				$("#carregando'.$r->id.'").html(\'<img src="http://provab2013.saude.gov.br/imgs/carregando.gif" style="height:30px">\');
  				$.post("'. base_url() .'home/enviarEmail/"+idcod,
    			{
		
   				},
    			function(data, status)
				{      
							   
	  				 $("#carregando'.$r->id.'").html(data);
					 '.$rs.'
	   
    			}).done(function() {

 				})
  				.fail(function() {
					$("#carregando'.$r->id.'").html(\'<span style="color:#AC0002">Falhou</span>\');
   					//$("#carregando'.$r->id.'").enviarEmail'.$r->id.'("'.$r->id.'");
  				})
  				.always(function() {
   
				});
			};
			
			 setTimeout(function(){}, 2000);
			 
			  $("#carregando'.$r->id.'").enviarEmail'.$r->id.'("'.$r->id.'");
			
			';
			//exit();
		}
		
		
		$cadastros =  $this->ObjCadastro->consultarRegistrosFalhos();
		foreach($cadastros as $r)
		{
			echo '<div class="divlinha" >'. $r->nome. ' - '.$r->email.'('.$r->codExterno.') <span style="float:right;"><span style="color:#AC0002">Sem Anexo</span></span></div>';
		}
		
		echo  $this->parser->parse('enviar02',array('total'=>0,'script'=>$scripts), TRUE);
				
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function logs()
	{
		
		echo  $this->parser->parse('log',array(), TRUE);
		
		$this->load->model('cadastro', 'ObjCadastro');
		$cadastros =  $this->ObjCadastro->consultarRegistrosGeral();
		$h = 1;
		foreach($cadastros as $r)
		{
			//$this->enviarEmail($r->id);
			$msn = '';
				if($r->status==0)
				$msn =  '<span class="corAmarela">Não foi enviado ainda </span>';
			else if($r->status==1)
			    $msn =  '<span class="corVerde">Enviado</span>';
			else
				$msn =  '<span class="corVemelha">Não enviado - Não encontrou aquivo para enviar</span>';
			
			echo '<div class="divlinha" >'. $r->nome. ' - '.$r->email.'('.$r->codExterno.') <span  style="float:right;">'. $msn .'</span></div>';
			
			
			
			
			
		}
		
		
		
		echo  $this->parser->parse('enviar02',array('total'=>0,'script'=>$scripts), TRUE);
				
	}
	
	
	
	public function separarPlanilha()
	{
	
		$this->load->model('cadastro', 'ObjCadastro');
		$dh = opendir("arquivos/pdf/div"); 
		while (false !== ($filename = readdir($dh))) 
		{ 		
			if($filename<>'.' && $filename <>"..")
			{
				if(file_exists("arquivos/pdf/div/".$filename))
				{
					unlink("arquivos/pdf/div/".$filename);
				}
			}
		}

		if(file_exists("arquivos/pdf/boletos.pdf"))
		{
			if(!unlink("arquivos/pdf/boletos.pdf"))
			{
				echo  $this->parser->parse('separar01',array(), TRUE);
				echo '<span style="color:#AC0002"> Erro de Permissão ao excluir o arquivo atual! </span>';
				echo  $this->parser->parse('separar02',array('total'=>0), TRUE);
				
				return false;
				
			}
		}
		
		$config['upload_path']          = './arquivos/pdf/';
		$config['allowed_types']        = 'pdf';
		$config['max_size']             = 100000;
		$config['file_name']             = 'boletos.pdf';


		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('arquivo2'))
		{
			
			echo  $this->parser->parse('inicio01',array(), TRUE);
			$error = array('error' => $this->upload->display_errors());
			echo '<span style="color:#AC0002">Erro ao fazer upload do arquivo!<br>'. print_r($error).' </span>';
			echo  $this->parser->parse('inicio02',array('total'=>0), TRUE);
		}
		else
		{
			
		$this->ObjCadastro->deleteRegistroTextoBoleto();
		echo  $this->parser->parse('separar01',array(), TRUE);
		
		require_once('application/libraries/FPDF/fpdf.php');
	    require_once('application/libraries/FPDI/fpdi.php');
	
		$end_directory = "div";
		$filename = "arquivos/pdf/boletos.pdf";
		
		$new_path = preg_replace('/[\/]+/', '/', $end_directory.'/'.substr($filename, 0, strrpos($filename, '/')));
	
		if (!is_dir($new_path))
		{
			mkdir($new_path, 0777, true);
		}
	
		$pdf = new FPDI();
		$pagecount = $pdf->setSourceFile($filename); // How many pages?
	
	// Split each page into a new PDF //$pagecount
		for ($i = 1; $i <=$pagecount; $i++) 
		{
			$new_pdf = new FPDI('P','mm','Legal');
			$new_pdf->AddPage();
			$new_pdf->setSourceFile($filename);
			$new_pdf->useTemplate($new_pdf->importPage($i));
			
			try {
				$new_filename = "arquivos/pdf/div/boleto".$i.".pdf";
				//echo $new_filename;
				
				//
				$new_pdf->Output($new_filename, "F");
				
					$parser = new \Smalot\PdfParser\Parser();
					$pdf    = $parser->parseFile($new_filename);
					$text = $pdf->getText();
					
					
				
				
				echo "<a href=\"".base_url(). $new_filename."\" target=\"_blank\"> Pagina ".$i." separada </a><br />\n";
				
				$dados['texto'] = $text;
				$dados['arquivo'] = $new_filename;
				$this->ObjCadastro->salvarTextoBoleto($dados);
				
				
				
				} 
				catch (Exception $e) 
				{
					echo 'Caught exception: ',  $e->getMessage(), "\n";
				}
			}	
			
			$total = count($this->ObjCadastro->consultarRegistrosTextoBoleto());			
			echo  $this->parser->parse('separar02',array('total'=>$total), TRUE);
		}
	}
	
	
	
	
	public function excluirArquivos($idExcluir)
	{
		$this->load->model('cadastro', 'ObjCadastro');
		$this->ObjCadastro->deleteConfiguracao($idExcluir);
		
		echo '<script>alert("Arquivo excluido com sucesso!!"); 
			
			window.document.location.href="'.base_url().'";
			
			</script>';
		
	}
	
	public function anexarArquivos()
	{
		$this->load->model('cadastro', 'ObjCadastro');

		$config['upload_path']          = './arquivos/arquivoAnexo/';
		$config['allowed_types']        = 'gif|jpg|png|pdf';
		$config['max_size']             = 1000;
		
		


		$this->load->library('upload', $config);
		if ($this->upload->do_upload('arquivo3'))
		{
			$dataArquivos = $this->upload->data();
			$dados['tipo'] = 1;
			$this->ObjCadastro->deleteConfiguracao($dados['tipo']);
			$dados['arquivoNome'] =$dataArquivos['file_name'];
			$dados['tipoEnvio'] =$_POST['tipoEnvio'];
			$dados['assunto'] =$_POST['assunto'];
			$this->ObjCadastro->salvarConfiguracao($dados);
			
			echo '<script>alert("Arquivo inserido com sucesso!!"); 
			
			window.document.location.href="'.base_url().'";
			
			</script>';
			
		}
		else
		{
			$dados['assunto'] =$_POST['assunto'];
			$this->ObjCadastro->salvarConfiguracao($dados);
			
			echo '<script>alert("Salvo com sucesso!!"); 
			
			window.document.location.href="'.base_url().'";
			
			</script>';
		}
		
	}
	
	
	public  function validaEmail($email) 
	{
		$Domain = explode("@", $email);
		if(count($Domain)>1)
		{
    		$Result = checkdnsrr($Domain[1], "MX");
    		return($Result);
		}else{
			return false;
			
			}	
	}
	
	
	public function cadastrarPlanilha() 
	{
		if(file_exists("arquivos/xlsx/listaclientes.xlsx"))
		{
			if(!unlink("arquivos/xlsx/listaclientes.xlsx"))
			{
				echo  $this->parser->parse('inicio01',array(), TRUE);
				echo '<span style="color:#AC0002"> Erro de Permissão ao excluir o arquivo atual! </span>';
				echo  $this->parser->parse('inicio02',array('total'=>0), TRUE);
				
				return false;
				
			}
		}
		$config['upload_path']          = './arquivos/xlsx/';
		$config['allowed_types']        = 'xlsx';
		$config['max_size']             = 1000;
		$config['file_name']             = 'listaclientes.xlsx';


		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('arquivo'))
		{
			
			echo  $this->parser->parse('inicio01',array(), TRUE);
			$error = array('error' => $this->upload->display_errors());
			echo '<span style="color:#AC0002">Erro ao fazer upload do arquivo!<br>'. print_r($error).' </span>';
			echo  $this->parser->parse('inicio02',array('total'=>0), TRUE);
		}
		else
		{

			$file = "arquivos/xlsx/listaclientes.xlsx";
			$this->load->library('excel');
			$objPHPExcel = PHPExcel_IOFactory::load($file);
			$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
			
			echo  $this->parser->parse('inicio01',array(), TRUE);
			
			foreach ($cell_collection as $cell) 
			{
				$column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
				$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
				$data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
				
				if ($row == 1) {
					$header[$row][$column] = $data_value;
				} else {
					$arr_data[$row][$column] = $data_value;
					
				}
			}
			
			
	 
			//$data['header'] = $header;
			//$data['values'] = $arr_data;
	
			$this->load->model('cadastro', 'ObjCadastro');
			$this->ObjCadastro->deleteRegistro();
	
	
			for($l=2; $l<count($arr_data)+2; $l++)
			{
				
				if($this->validaEmail($arr_data[$l]["C"])){
				
					$dados['codExterno'] = $arr_data[$l]["A"];
					$dados['nome'] = $arr_data[$l]["B"];
					$dados['email'] = $arr_data[$l]["C"];
					$dados['login'] = $arr_data[$l]["D"];
					$dados['CPF'] = $arr_data[$l]["E"];
					
					if($this->ObjCadastro->salvarInscricao($dados))
					{
						echo "<strong>[ ".$arr_data[$l]["A"] ." ]</strong> ".$arr_data[$l]["B"]." - <span style=\"color:#046700\"> <strong>inserido</strong> </span><br>";
					}
					else
					{
						echo "<strong>[ ".$arr_data[$l]["A"] ." ] </strong>".$arr_data[$l]["B"]." - <span style=\"color:#AC0002\"> <strong>Erro ao Inserir</strong> </span><br>";
					}
				}
				else
				{
					echo "<strong>[ ".$arr_data[$l]["A"] ." ] </strong>".$arr_data[$l]["B"]." - <span style=\"color:#AC0002\"> <strong>E-Mail Inválido</strong> </span><br>";
				}
			}
			
			$total = count($this->ObjCadastro->consultarRegistros());
			echo $this->parser->parse('inicio02',array('total'=>$total), TRUE);
		
		}
	
	}
	
	
	public function teste(){
		
		echo mime_content_type   ("arquivos/pdf/div/boleto_10.pdf");
		
		
		}
	
	
}




?>
