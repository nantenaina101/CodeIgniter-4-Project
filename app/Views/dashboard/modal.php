
			<div class="modal fade" id="editCountry" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title" id="exampleModalLabel">Modifier le pays</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form action="<?= route_to('user.updateCountry') ?>" method="POST" id="formEdit">
	              			<?= csrf_field() ?>
	              			<!-- <input type="hidden" name="_method" value="PUT"> -->
	              			<input type="hidden" name="countryId" id="countryId">
			                <div class="modal-body">
			                  <div class="form-group">
			                    <label for="country_name">Pays</label>
			                    <input type="text" class="form-control" name="country_name" id="country_name" placeholder="Enter votre pays">
			                    <span class="text-danger error-text country_name_error"></span>
			                  </div>
			                  <div class="form-group">
			                    <label for="capital_city">Capital</label>
			                    <input type="text" class="form-control" name="capital_city" id="capital_city" placeholder="Enter le capital">
			                    <span class="text-danger error-text capital_city_error"></span>
			                  </div>
			                </div>
			                <div class="modal-footer">
			                	<button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
			                  	<button type="submit" class="btn btn-primary">Enregistrer</button>
			                </div>
			              </form>
						
					</div>
				</div>
			</div>