		<div class="modal fade" id="editModal" role="modal">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Formulaire de modification d'un article</h4>
						<button type="button" class="close btnClose" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form action="<?= route_to('user.update_post') ?>" method="POST" enctype="multipart/form-data" id="formEdit">
						<?= csrf_field() ?>
						<input type="hidden" name="editId" id="editId">
						<input type="hidden" name="editImage" id="editImage">
						<div class="modal-body">
							<div class="form-group">
								<label for="titre">Titre</label>
								<input type="text" name="title" class="form-control" id="titleEdit" placeholder="Entrer le titre">
								<span class="text-danger error-text title_error"></span>
							</div>
							<div class="form-group">
								<label for="titre">Catégorie</label>
								<input type="text" name="category" class="form-control" id="categoryEdit" placeholder="Entrer la catégorie">
								<span class="text-danger error-text category_error"></span>
							</div>
							<div class="form-group">
								<label for="titre">Description</label>
								<textarea name="body" cols="3" rows="3" class="form-control bodyEdit" id="bodyEdit"></textarea>
								<span class="text-danger error-text body_error"></span>
							</div>
							<div class="form-group">
								<label for="titre">Image</label>
								<input onchange="apercuEdit(event)" type="file" name="image" id="imageEdit" accept="image/*">
								<span class="text-danger error-text image_error"></span>
							</div>
							<div id="imgAperEdit"></div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary btnClose" data-dismiss="modal" onclick="clearForm()">Fermer</button>
							<button type="button" class="btn btn-primary" id="btnEdit">Modifier</button>
						</div>
					</form>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->