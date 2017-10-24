<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class cadastro extends CI_model
{
	function salvarInscricao($dados)
	{	

			if($this->db->insert('boletos', $dados))
			{
				return true;
			} 			

	} 
	
	
	function salvarConfiguracao($dados)
	{	

			if($this->db->insert('configuracao', $dados))
			{
				return true;
			} 			

	} 
	
	
	function selecionarConfiguracao($tipo)
	{	

		
		
		$query2 = $this->db->query('SELECT * FROM configuracao where tipo='.$tipo); 		
		return $query2->result();
		
	}
	
	function deleteConfiguracao($tipo)
	{	

		
		
		$query2 = $this->db->query('SELECT * FROM configuracao'); 		
		$resultado = $query2->result();
		
		foreach($resultado as $t)
		{
			if($t ->arquivoNome)
			{
				if(file_exists("arquivos/arquivoAnexo/".$t ->arquivoNome))
					unlink("arquivos/arquivoAnexo/".$t ->arquivoNome);
			}
		}
		
		$query = $this->db->query('DELETE FROM configuracao where tipo='.$tipo);
		
						

	} 
	
	
	
	
	
	
	
	
	
	function deleteRegistro()
	{
		$query = $this->db->query('DELETE  FROM boletos');	
		$query = $this->db->query('ALTER TABLE boletos AUTO_INCREMENT = 1');	
		
	}
	
	
	function consultarRegistros($id = 0)
	{
		if($id)
			$and = ' and id='.$id;
		$query = $this->db->query("SELECT * FROM boletos where status=0 ".$and); 		
		return $resultado = $query->result();		
		
	}
	
	
		function consultarRegistrosGeral()
	{
	
		$query = $this->db->query("SELECT * FROM boletos"); 		
		return $resultado = $query->result();		
		
	}
	
	
	function consultarRegistrosFalhos($id = 0)
	{
		if($id)
			$and = ' and id='.$id;
		$query = $this->db->query("SELECT * FROM boletos where status=2 ".$and); 		
		return $resultado = $query->result();		
		
	}
	
	
	
	
    function consultarRegistrosTextos($texto)
	{
		$query = $this->db->query("SELECT * FROM arquivosTexto where texto LIKE '%".$texto."%'");
		
		 		
		return $resultado = $query->result();		
		
	}
	
	function mudarStatus($dados, $id)
	{
			$this->db->where('id', $id);
			$this->db->update('boletos', $dados); 
	
	}
	
	
	function salvarTextoBoleto($dados)
	{	

			if($this->db->insert('arquivosTexto', $dados))
			{
				return true;
			} 			

	} 
	
	
	function deleteRegistroTextoBoleto()
	{
		$query = $this->db->query('DELETE  FROM arquivosTexto');	
		$query = $this->db->query('ALTER TABLE arquivosTexto AUTO_INCREMENT = 1');	
		
	}
	
	
	function consultarRegistrosTextoBoleto()
	{
		$query = $this->db->query("SELECT * FROM arquivosTexto"); 		
		return $resultado = $query->result();		
		
	}
	
	
		
	
}

