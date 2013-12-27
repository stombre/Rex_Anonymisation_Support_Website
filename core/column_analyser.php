<?php

class column_analyser
{
	private $name;
	private $type;
	private $key;
	private $result = '';
	private $rules_suggested = array();
	
	function __construct($column_name, $column_type, $column_key)
	{
		$this->rules_suggested['sub_str'] = false;
		$this->rules_suggested['sub_date'] = false;
		$this->rules_suggested['sub_int'] = false;
		$this->rules_suggested['shuffle'] = false;
		$this->rules_suggested['commandSQL'] = true;//Toujours possible
		$this->rules_suggested['hash'] = false;
		$this->rules_suggested['var_int'] = false;
		$this->rules_suggested['var_date'] = false;
		$this->rules_suggested['mask_str'] = false;
		$this->rules_suggested['mask_mail'] = false;
		$this->rules_suggested['concatenation'] = false;
		
		$this->name = $column_name;
		$this->type = $column_type;
		$this->key = $column_key;
		if($this->key != 'PRI')
		{
			$this->analyseName();
			$this->analyseType();
		}
	}
	
	public function getResult()
	{
		$result = '<ul>';
		foreach($this->rules_suggested as $key => $value)
		{
			if($value == true)
			{
				switch($key)
				{
					case 'sub_str':
						$result .= '<li>Substitution de string (avec dictionnaire)</li>';
						break;
					case 'sub_date':
						$result .= '<li>Substitution de date (avec intervale)</li>';
						break;
					case 'sub_int':
						$result .= '<li>Substitution d\'entier (avec intervale)</li>';
						break;
					case 'shuffle':
						$result .= '<li>Shuffle</li>';
						break;
					case 'commandSQL':
						$result .= '<li>Executer une commande SQL</li>';
						break;
					case 'var_int':
						$result .= '<li>Variance d\'entier (avec intervale)</li>';
						break;
					case 'var_date':
						$result .= '<li>Variance de date (avec intervale)</li>';
						break;
					case 'mask_str':
						$result .= '<li>Masker une partie de la string</li>';
						break;
					case 'mask_mail':
						$result .= '<li>Masker une adresse mail</li>';
						break;
					case 'concatenation':
						$result .= '<li>Concatenation</li>';
						break;
				}
			}
		}
		$result .= '</ul>';
		return $result;
	}
	
	private function analyseName()
	{
		$name = $this->name;
		if(preg_match('/name/i', $name) or preg_match('/nom/i', $name))
		{
			$this->rules_suggested['sub_str'] = true;
		}
		if(preg_match('/date/i', $name))
		{
			$this->rules_suggested['var_date'] = true;
			$this->rules_suggested['sub_date'] = true;
		}
		if(preg_match('/mail/i', $name))
		{
			$this->rules_suggested['mask_mail'] = true;
		}
		if(preg_match('/ip/i', $name))
		{
		}
		if(preg_match('/url/i', $name))
		{
		}
	}
	
	private function analyseType()
	{
		$type = $this->type;
		if(preg_match('/CHAR/i', $type))
		{
			$this->rules_suggested['sub_str'] = true;
			$this->rules_suggested['hash'] = true;
			$this->rules_suggested['shuffle'] = true;
			$this->rules_suggested['mask_str'] = true;
			$this->rules_suggested['concatenation'] = true;
		}
		if(preg_match('/INT/i', $type))
		{
			$this->rules_suggested['var_int'] = true;
			$this->rules_suggested['sub_int'] = true;
		}
		if(preg_match('/DATE/i', $type))
		{
			$this->rules_suggested['var_date'] = true;
			$this->rules_suggested['sub_date'] = true;
		}
	}
}

?>