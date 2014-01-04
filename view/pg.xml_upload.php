<div class="panel panel-default">
	<div class="panel-body">
	<h1>Upload XML</h1>
	<p>Upload d'un fichier XML d'anonymisation :
	<form method="POST" action="?p=put_xml" enctype="multipart/form-data">
		Fichier : <input type="file" name="xml"/><br/>
		Database url: <input type="text" name="db_url" value="localhost"><br/>
		Database identifiant: <input type="text" name="db_id" value="root"><br/>
		Database password: <input type="text" name="db_pass"><br/>
		Database name: <input type="text" name="db_name"><br/>
		<input type="submit" value="Envoyer le fichier"/>
	</form> 
	</p>
	</div>
</div>