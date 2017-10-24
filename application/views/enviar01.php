<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Sistema de envio de e-mail</title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
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
	.divlinha{
		
		width:98%; text-align:justify;
		font-size:14px;
		font-weight:bold;
		padding:1%;
		height:30px;
		padding-top:15px;
		border:1px solid #DCDCDC;
		margin-bottom:10px;
		display:table;
				
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
	
	
	.corVemelha {
		
		color:#BF0003;
		
		
		}
		
			.corAmarela {
		
		color:#FF8E00;
		
		
		}
		
		.corVerde{
			
			color:#008026;
			
			}
	
	</style>
    
    
  
    
    
</head>
<body>
<div id="container">
<div style="text-align:center"><img src="<?php echo base_url();?>arquivos/logo.png" style="margin:20px"></div>


	<h1>Envio de E-mail</h1>

  <div id="body">
		
        <img src="<?php echo base_url();?>arquivos/cafezinho2.png" align="left" height="50" style="margin:15px">
        <p style="color:#AC0002; font-size:15px; padding-top:10px">
        <strong style="">Esse processo é muito Demorado, é hora de tomar um cafezinho, relaxar, mais não feche essa janela, fique atento ao processo, se ocorrer travamento, atualize a pagina, não preocupe que que os clientes irão receber apenas um e-mail de cobraça.</strong></p>
	</div>

	 <code>