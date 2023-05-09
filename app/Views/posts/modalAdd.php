		<div class="modal fade" id="addModal" role="modal">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Formulaire d'ajout d'un article</h4>
						<button type="button" class="close btnClose" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form action="<?= route_to('user.add_post') ?>" method="POST" enctype="multipart/form-data" id="formAdd">
						<?= csrf_field() ?>
						<div class="modal-body">
							<div class="form-group">
								<label for="titre">Titre</label>
								<input type="text" name="title" class="form-control" id="title" placeholder="Entrer le titre">
								<span class="text-danger error-text title_error"></span>
							</div>
							<div class="form-group">
								<label for="titre">Catégorie</label>
								<input type="text" name="category" class="form-control" id="category" placeholder="Entrer la catégorie">
								<span class="text-danger error-text category_error"></span>
							</div>
							<div class="form-group">
								<label for="titre">Description</label>
								<textarea name="body" cols="3" rows="3" class="form-control" id="body"></textarea>
								<span class="text-danger error-text body_error"></span>
							</div>
							<div class="form-group">
								<label for="titre">Image</label>
								<input onchange="apercuAdd(event)" type="file" name="image" id="image" accept="image/*">
								<span class="text-danger error-text image_error"></span>
							</div>
							<div id="imgAperAdd"></div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary btnClose" data-dismiss="modal">Fermer</button>
							<button type="submit" class="btn btn-primary" id="btnAdd">Enregistrer</button>
						</div>
					</form>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->