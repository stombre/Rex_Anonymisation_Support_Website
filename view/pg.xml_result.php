<div class="panel panel-default">
	<div class="panel-body">
		<div class="alert alert-success">Succ&#232;s de l'anonymisation ! Vos donn&#233;es anonymis&#233;es ce trouve dans les tables pr&#233;fixer par REX_.</br>
		<ul>
			<?php
			foreach($table_rapport as $key => $v)
			{
				echo '<li>'.$v.' r&#232;gle(s) appliqu&#233;e(s) sur la table '.$key.'.</li>';
			}
			?>
		</ul>
		</div>
	</div>
</div>