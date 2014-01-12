<div class="panel panel-default">
	<div class="panel-body">
	<h1>Upload XML</h1>
	<p>Upload d'un fichier XML d'anonymisation :
	<form class="form-horizontal" role="form" method="POST" action="?p=put_xml" enctype="multipart/form-data">
		<div class="form-group">
			<label for="inputFile" class="col-sm-2 control-label">Fichier :</label>
			<div class="col-sm-10">
				<input type="file" name="xml" class="form-control" id="inputFile" placeholder="File"/>
			</div>
		</div>
		<div class="form-group">
			<label for="databaseUrl" class="col-sm-2 control-label">Database url :</label>
			<div class="col-sm-10">
				<input  type="text" name="db_url" value="localhost" class="form-control" id="databaseUrl" placeholder="Database Url"/>
			</div>
		</div>
		<div class="form-group">
			<label for="databaseId" class="col-sm-2 control-label">Database identifiant :</label>
			<div class="col-sm-10">
				<input type="text" name="db_id" value="root" type="email" class="form-control" id="databaseId" placeholder="Database identifiant"/>
			</div>
		</div>
		<div class="form-group">
			<label for="databasePass" class="col-sm-2 control-label">Database password :</label>
			<div class="col-sm-10">
				<input type="text" name="db_pass" class="form-control" id="databasePass" placeholder="Database password"/>
			</div>
		</div>
		<div class="form-group">
			<label for="databaseName" class="col-sm-2 control-label">Database name :</label>
			<div class="col-sm-10">
				<input type="text" name="db_name" class="form-control" id="databaseName" placeholder="Database name"/>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-12">
				<input type="submit" value="Envoyer le fichier" class="form-control"/>
			</div>
		</div>
		</div>
	</form> 
	</p>
	</div>
</div>