<?= $this->extend('layout/dashboard-layout') ?>
<?= $this->section('content') ?>
	<?= $this->include('dashboard/modal') ?>
	<div class="row">
          <div class="col-md-8">
          	<div class="card card-secondary">
	            <div class="card-header">
	              <h3 class="card-title">Liste de pays</h3>
	            </div>
	            <div class="card-body">
	            	<table class="table align-middle text-center">
	            		<thead class="table-dark">
	            			<tr>
	            				<th>#</th>
	            				<th>Pays</th>
	            				<th>Capital</th>
	            				<th>Actions</th>
	            			</tr>
	            		</thead>
	            		<tbody>
	            			<tr>
	            				<td colspan="4">Chargement...</td>
	            			</tr>
	            		</tbody>
	            	</table>
	            </div>
	        </div>
          </div>
          <div class="col-md-4">
            <!-- general form elements -->
            <div class="card card-primary">
	              <div class="card-header">
	                <h3 class="card-title">Ajouter un pays</h3>
	              </div>
	              <!-- /.card-header -->
	              <!-- form start -->
	              <form action="<?= route_to('user.addCountry') ?>" method="POST" id="formAdd">
	              	<?= csrf_field() ?>
	                <div class="card-body">
	                  <div class="alert alert-success d-none" role="alert" id="successMessageAdd">
	                  	 
	                  </div>
	                  <div class="form-group">
	                    <label for="country_name">Pays</label>
	                    <input type="text" class="form-control" name="country_name" placeholder="Enter votre pays">
	                    <span class="text-danger error-text country_name_error"></span>
	                  </div>
	                  <div class="form-group">
	                    <label for="capital_city">Capital</label>
	                    <input type="text" class="form-control" name="capital_city" placeholder="Enter le capital">
	                    <span class="text-danger error-text capital_city_error"></span>
	                  </div>
	                </div>
	                <div class="card-footer">
	                  <button type="submit" class="btn btn-primary">Enregistrer</button>
	                </div>
	              </form>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
	<script type="text/javascript">
		$(document).ready(function(){

			showContry();

			$('#formAdd').on('submit', function(e){
				e.preventDefault();
				let form = this;
				$.ajax({
					url: $(form).attr('action'),
					method: $(form).attr('method'),
					data: new FormData(form),
					processData: false,
					contentType: false,
					dataType: 'json',
					beforeSend: function() {
						$(form).find('span.error-text').text('');
						$('#successMessageAdd').addClass('d-none');
					},
					success: function(response) {
						if ($.isEmptyObject(response.error)) {
							if(response.code == 1){
								$(form)[0].reset();
								// alert(response.message);
								$('#successMessageAdd').removeClass('d-none');
								$('#successMessageAdd').text(response.message);
								showContry();
								setTimeout(function() {$('#successMessageAdd').addClass('d-none'); }, 5000);
							}
							else{
								alert(response.message);
							}
						} else {
							$.each(response.error, function(cle, valeur){
								$(form).find('span.'+cle+'_error').text(valeur);
							});
						}
					},
					error : (error) => {
						console.log(error);
					}
				});
			});

			function showContry() {
				$.ajax({
					url: "<?= route_to('user.listCountry') ?>",
					method: "GET",
					success: function(response){
						$('tbody').html(response);
						$('table').dataTable();
					}
				});
			}

			$(document).on('click', '.editCountry', function(){
				let tr = $(this).closest('tr');
				let data = tr.children('td').map(function(){
					return $(this).text();
				}).get();
				$('#editCountry').modal('show');
				$('#countryId').val(data[0]);
				$('#country_name').val(data[1]);
				$('#capital_city').val(data[2]);
			});

			$('#formEdit').on('submit', function(e){
				e.preventDefault();
				let form = this;
				$.ajax({
					url: $(form).attr('action'),
					method: $(form).attr('method'),
					data: new FormData(form),
					processData: false,
					contentType: false,
					dataType: 'json',
					beforeSend: function() {
						$(form).find('span.error-text').text('');
					},
					success: function(response) {
						if ($.isEmptyObject(response.error)) {
							if(response.code == 1){
								$(form)[0].reset();
								// alert(response.message);
								$('#editCountry').modal('hide');
								Swal.fire({
									title: response.title,
									icon: response.icon,
									button: response.button
								});
								showContry();
							}
							else{
								alert(response.message);
							}
						} else {
							$.each(response.error, function(cle, valeur){
								$(form).find('span.'+cle+'_error').text(valeur);
							});
						}
					}
				});
			});

			$(document).on('click', '.deleteCountry', function(){
				let id = $(this).data('id');
				let country = $(this).data('country');
				Swal.fire({
					title: "Etes vous sûr ?",
					html: "De vouloir supprimer " + country + " de cette liste ?",
					icon: "warning",
					buttons: true,
					dangerMode: true,
					showCloseButton: true,
					cancelButtonText: "Non",
					confirmButtonText: "Oui",
					cancelButtonColor: "blue",
					confirmButtonColor: "grey",
					allowOutsideClick: false
				}).then(function(res){
					if (res.value) {
						$.ajax({
						url: 'user/deleteCountry/' + id,
						dataType: 'json',
						success: function(response){
							if (response.code == 1) {
								Swal.fire({
									title: response.title,
									icon: response.icon,
									button: response.button
								});
								showContry();
							} else {
								alert(response.message);
							}
						}
					});	
					}
				});	
			});
		});
	</script>
<?= $this->endSection() ?>