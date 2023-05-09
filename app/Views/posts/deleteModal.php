		<div class="modal fade" id="deleteModal" role="modal">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Suppression d'un article</h4>
						<button type="button" class="close btnClose" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form action="<?= route_to('user.deletePost') ?>" method="POST" id="formDelete">
						<?= csrf_field() ?>
						<input type="hidden" name="deleteId" id="deleteId">
						<input type="hidden" name="deleteImage" id="deleteImage">
						<div class="modal-body">
							<div>Etes vous sur de vouloir supprimer <span class="font-weight-bold" id="spanTitleDelete"></span> de la liste des articles ?</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary btnClose" data-dismiss="modal">Non</button>
							<button type="button" class="btn btn-danger" id="btnDelete">Oui</button>
						</div>
					</form>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->