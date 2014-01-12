<?php
//RuleShuffle ; Mélanger le champ
class RuleShuffle extends Rule
{	
	public function __construct($table, $column)
	{
		parent::__construct($table, $column);
	}
	
	public function launch($pdo)
	{
		$q = $pdo->query('SELECT ' . $this->targetColumn . ' FROM ' . $this->targetTable);
		$values = array();
		$i = 0;
		while($dt = $q->fetch())
		{
			$values[$i] = $dt[(string)$this->targetColumn];
			$i++;
		}
		shuffle($values);
		
		$i = 0;
		while($dt = $q->fetch())
		{
			$pdo->exec('UPDATE ' . $this->targetTable . ' SET ' . $this->targetColumn . ' = \'REX_'.$values[$i].'\' WHERE ' . $this->targetColumn . ' = \'' . $dt[$this->targetColumn] . '\'');
			$i++;
		}
		$pdo->exec('UPDATE '.$this->targetTable.' SET '.$this->targetColumn .'= SUBSTR('.$this->targetColumn .', 5)');
		$q -> closeCursor();
	}
}