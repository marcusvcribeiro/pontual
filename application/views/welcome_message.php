<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Sistema de envio de e-mail</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color:#F3F3F3;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
		background-color:#FFFFFF;
	}
	</style>
</head>
<body>

<div id="container">
<div style="text-align:center"><img src="<?php echo base_url();?>arquivos/logo.png" style="margin:20px"></div>

	<h1>Bem Vindo ao sistema de envio de Boletos!</h1>

	<div id="body">
		<p>Sistema personalizado para envio de boletos para e-mails.</p>
		

		<p>Primeiramente você deve cadastrar uma planilha padronizada em excel de cadastro dos boletos, para ser inserido ao banco de dados, clique no botão.</p>
		<code>
        <form method="post" action="home/cadastrarPlanilha"  enctype="multipart/form-data">
        <div class="form-group">
    <label for="exampleInputFile">Aquivo </label>
    <input type="file" id="exampleInputFile" name="arquivo" required>
    <p class="help-block">Aquivo XLS</p>
  </div>
        <input type="submit" value="Cadastrar planilha" class="btn btn-primary">
        </form>
        </code>
        
        
        
        <p>Separar o arquivo PDF.</p>
		<code>
        <form method="post" action="home/separarPlanilha"  enctype="multipart/form-data">
        <div class="form-group">
    <label for="exampleInputFile">Aquivo </label>
    <input type="file" id="exampleInputFile" name="arquivo2" required>
    <p class="help-block">Aquivo PDF</p>
  </div>
        <input type="submit" value="Separar Arquivos" class="btn btn-primary">
        </form>
        </code>
        
        
        
        
        
        
        
        <p>Caso deseja que os clientes recebar arquivos em anexo, cadastre esse arquivo aqui. Também pode mudar o Assunto da mensagem</p>
		<code>
        <form method="post" action="home/anexarArquivos"  enctype="multipart/form-data">
        <div class="form-group">
        <?php 
  foreach($arquivosAdicional01 as $t)
		{
			$assunto = $t ->assunto;
		}
      
			
			?>
           <label for="exampleInputFile">Assunto </label>
    <input type="text" id="exampleInputFile" name="assunto" value="<?php echo $assunto; ?>" required  style="width:100%">
      <p class="help-block">&nbsp;</p>   
        
    <label for="exampleInputFile">Aquivo </label>
    <input type="file" id="exampleInputFile" name="arquivo3" >
    <p class="help-block">Aquivo PDF, IMAGENS</p>
 <?
  foreach($arquivosAdicional01 as $t)
		{
			if($t ->arquivoNome)
			{
				
				$tipoEnvio = $t ->tipoEnvio;
				$extension = pathinfo("arquivos/arquivoAnexo/".$t ->arquivoNome);
				if($extension['extension']=='pdf')
						echo '<a href="'.base_url().'/arquivos/arquivoAnexo/'.$t ->arquivoNome.'" target="_blank"  style="color:#E30003">Visualizar aquivo cadastrado</a><br><br>';
					else
						echo '<img src="'.base_url().'/arquivos/arquivoAnexo/'.$t ->arquivoNome.'"  height="200px"><br><br>';
						
						
				echo '<input type="button" value="Excluir Arquivo" onClick="window.document.location.href=\''.base_url().'home/excluirArquivos/1\'" class="btn btn-danger"><br><br>';		
				
			}
			
		}
 
 ?>   
     <label for="exampleInputFile">Deseja que o arquivo apareça no copo do email? </label><br>
     <input type="radio" value="0" id="sim" name="tipoEnvio" <?php if($tipoEnvio<>1) echo 'checked'; ?>><label for="sim">Não, somente anexo</label>
     <input type="radio" value="1" id="sim" name="tipoEnvio" <?php if($tipoEnvio==1) echo 'checked'; ?>><label for="sim">Sim <span class="font10"  >(Somente para imagens)</span></label>
  </div>
        <input type="submit" value="Salvar configuração" class="btn btn-primary">
        </form>
        </code>
        
        
      
        
        
        
        
        

		<p>Por fim ao clicar no botão abaixo, o sistema irá buscar no banco cadastro de boletos e irá enviar ao cliente</p>
        
        <code> <input type="button" onClick="window.document.location.href='<?php echo base_url()?>home/dispararEmails'" value="Disparar E-mails" class="btn btn-primary">
        
        <input type="button" onClick="window.document.location.href='<?php echo base_url()?>home/logs'" value="Logs de envios" class="btn btn-warning">
        
        
        </code>
	</div>
    <p class="footer">Desenvolvido por Navicat Versão 01 [Beta]</p>

</div>

</body>
</html>