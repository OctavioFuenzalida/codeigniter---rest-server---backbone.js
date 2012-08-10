<script type="text/javascript">
	$LAB.script("<?php echo base_url("assets/modules/blog/controllers/blog_app.js");?>").wait(function(){
		page.init();
	});
</script>
	<h1>
		<i class="icon-th-list"></i> Blogs
		<span id=loader class="loader progress progress-striped active"><span class="bar"></span></span>
	</h1>


	<!-- underscore template for the collection -->
	<script type="text/template" id="blogCollectionTemplate">
		<table class="collection table table-bordered">
		<thead>
			<tr>
				<th>Id</th>
				<th>Titulo</th>
				<th>Cuerpo</th>
				<th>Actualizado</th>
				<th>Creado</th>
			</tr>
		</thead>
		<tbody>
		<% items.each(function(item) { %>
			<tr id="<%= _.escape(item.get('idBlog')) %>">
				<td><%= _.escape(item.get('idBlog') || '') %></td>
				<td><%= _.escape(item.get('titleBlog') || '') %></td>
				<td><%= _.escape(item.get('bodyBlog') || '') %></td>
				<td><%= _date(app.parseDate(item.get('updatedBlog'))).format('MMM D, YYYY h:mm A') %></td>
				<td><%= _date(app.parseDate(item.get('createdBlog'))).format('MMM D, YYYY h:mm A') %></td>
			</tr>
		<% }); %>
		</tbody>
		</table>

		<%=  view.getPaginationHtml(page) %>
	</script>

	<!-- underscore template for the model -->
	<script type="text/template" id="blogModelTemplate">
		<form class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div id="idBlogInputContainer" class="control-group">
					<label class="control-label" for="idBlog">Id Blog</label>
					<div class="controls inline-inputs">
						<span class="input-xlarge uneditable-input" id="idBlog"><%= _.escape(item.get('idBlog') || '') %></span>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="titleBlogInputContainer" class="control-group">
					<label class="control-label" for="titleBlog">Titulo Blog</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="titleBlog" placeholder="Title Blog" value="<%= _.escape(item.get('titleBlog') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="bodyBlogInputContainer" class="control-group">
					<label class="control-label" for="bodyBlog">Cuerpo Blog</label>
					<div class="controls inline-inputs">
						<textarea class="input-xlarge" id="bodyBlog" rows="3"><%= _.escape(item.get('bodyBlog') || '') %></textarea>
						<span class="help-inline"></span>
					</div>
				</div>
			</fieldset>
		</form>

		<!-- delete button is is a separate form to prevent enter key from triggering a delete -->
		<form id="deleteBlogButtonContainer" class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<button id="deleteBlogButton" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i> Borrar Item</button>
						<span id="confirmDeleteBlogContainer" class="hide">
							<button id="cancelDeleteBlogButton" class="btn btn-mini">Cancelar</button>
							<button id="confirmDeleteBlogButton" class="btn btn-mini btn-danger">Confirmar</button>
						</span>
					</div>
				</div>
			</fieldset>
		</form>
	</script>

	<!-- modal edit dialog -->
	<div class="modal hide fade" id="blogDetailDialog">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">&times;</a>
			<h3>
				<i class="icon-edit"></i> Editar Blog
				<span id="modelLoader" class="loader progress progress-striped active"><span class="bar"></span></span>
			</h3>
		</div>
		<div class="modal-body">
			<div id="modelAlert"></div>
			<div id="blogModelContainer"></div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" >Cancelar</button>
			<button id="saveBlogButton" class="btn btn-primary">Guardar Cambios</button>
		</div>
	</div>

	<div id="collectionAlert"></div>

	<div id="blogCollectionContainer" class="collectionContainer">
	</div>

	<p id="newButtonContainer" class="buttonContainer">
		<button id="newBlogButton" class="btn btn-primary">Agregar un nuevo Item</button>
	</p>
