<?= $this->extend('layout/dashboard-layout') ?>
<?= $this->section('content') ?>
<?= $this->include('posts/modalAdd') ?>
<?= $this->include('posts/modalShow') ?>
<?= $this->include('posts/editModal') ?>
<?= $this->include('posts/deleteModal') ?>
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="card-shadow">
					<div class="card-header align-items-center">
						<button type="button" data-toggle="modal" data-target="#addModal" class="btn btn-dark mr-0" style="float: right;">Ajouter un article</button>
						<div class="text-secondary font-weight-bold" style="font-size: 20px;">Tous les articles</div>
					</div>
					<div class="card-body">
						<div class="row" id="contenu">

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
	<script type="text/javascript">
		$(document).ready(function(){
			
			showAllPost();

			$(document).on('click', '.btnClose', function(){
				$('#formAdd')[0].reset();
				$('#formAdd').find('span.error-text').text('');
				$('#formEdit').find('span.error-text').text('');
			});

			$('#formAdd').on('submit', function(e){
				e.preventDefault();
				let form = this;
				$.ajax({
					url: $(form).attr('action'),
					type: $(form).attr('method'),
					data: new FormData(form),
					processData: false,
					cache: false,
					contentType: false,
					dataType: 'json',
					beforeSend: function() {
						$(form).find('span.error-text').text('');
					},
					success: function(response) {
						if ($.isEmptyObject(response.error)) {
							if(response.code == 1){
								$(form)[0].reset();
								$('#addModal').modal('hide');
								Swal.fire({
									title: response.title,
									icon: response.icon,
									button: response.button
								});
								showAllPost();
							}
						} 
						else {
							$.each(response.error, function(cle, valeur){
								$(form).find('span.'+cle+'_error').text(valeur);
							});
						}
					}
				});
			});

			function showAllPost() {
				$.ajax({
					url: "<?= route_to('user.listPost') ?>",
					method: "GET",
					success: function(response){
						$('#contenu').html(response);
					}
				});
			}

			$(document).on('click', '#imageModal', function(e){
				e.preventDefault();
				let title = $(this).parent().parent().find('div.title').text();
				let categorie = $(this).parent().parent().find('div.category').text();
				let body = $(this).parent().parent().find('p.body').text();
				let source = $(this).parent().parent().find('input#imgShow').val();
				$('#showModal').modal('show');
				$('#imgAper').html('<img width="100%" height="100%" src="images/'+source+'">');
				$('#titleAper').text(title);
				$('#titleAperc').text(title);
				$('#categoryAper').text(categorie);
				$('#bodyAper').text(body);
			});

			$(document).on('click', '.editPostBtn', function(){
				$('#editModal').modal('show');
				let id = $(this).parent().parent().parent().find('input#idList').val();
				let title = $(this).parent().parent().parent().find('div.title').text().toString().trim();
				let categorie = $(this).parent().parent().parent().find('div.category').text().toString().trim();
				let body = $(this).parent().parent().parent().find('p.body').text();
				let source = $(this).parent().parent().parent().find('input#imgShow').val();
				$('#imgAperEdit').html('<img width="120px;" height="120px;" src="images/'+source+'">');
				$('#editId').val(id);
				$('#editImage').val(source);
				$('#titleEdit').val(title);
				$('#categoryEdit').val(categorie);
				$('#bodyEdit').text(body);
			});

			$(document).on('click', '#btnEdit', function(e){
				e.preventDefault();
				let form = document.querySelector('#formEdit');
				$.ajax({
					url: $(form).attr('action'),
					type: $(form).attr('method'),
					data: new FormData(form),
					processData: false,
					cache: false,
					contentType: false,
					dataType: 'json',
					beforeSend: function() {
						$(form).find('span.error-text').text('');
					},
					success: function(response) {
						if ($.isEmptyObject(response.error)) {
							if(response.code == 1){
								$('#editModal').modal('hide');
								Swal.fire({
									title: response.title,
									icon: response.icon,
									button: response.button
								});
								showAllPost();
							}
						} 
						else {
							$.each(response.error, function(cle, valeur){
								$(form).find('span.'+cle+'_error').text(valeur);
							});
						}
					}
				});
			});

			$(document).on('click', '.deletePostBtn', function(){
				let id = $(this).parent().parent().parent().find('input#idList').val();
				let title = $(this).parent().parent().parent().find('div.title').text().toString().trim();
				let source = $(this).parent().parent().parent().find('input#imgShow').val();
				$('#deleteModal').modal('show');
				$('#deleteId').val(id);
				$('#deleteImage').val(source);
				$('#spanTitleDelete').text(title);
			});

			$(document).on('click', '#btnDelete', function(){
				let form = document.querySelector('#formDelete');
				$.ajax({
					url: $('#formDelete').attr('action'),
					type: $('#formDelete').attr('method'),
					data: new FormData(form),
					processData: false,
					cache: false,
					contentType: false,
					dataType: 'json',
					success: function(response) {
						$('#deleteModal').modal('hide');
						Swal.fire({
							title: response.title,
							icon: response.icon,
							button: response.button
						});
						showAllPost();
					}
				});
			});
		});
		/*document.querySelectorAll(".overflow-ellipsis").forEach(body=>{
			body.addEventListener("click", ()=>{
				if(body.style.includes("text-overflow")){
					alert("Ok")
				}
			})
		})*/
		function showOrHide(paragraphe){
			if(paragraphe.style.overflow){
				paragraphe.style = "cursor:pointer;";
			}else{
				paragraphe.style = "cursor:pointer;text-overflow:ellipsis;white-space:nowrap;overflow:hidden;";
			}
		}

		function apercuAdd(event){
			let file = event.target.files[0]
			document.querySelector("#imgAperAdd").innerHTML = '<img width="120px;" height="120px;" src="'+URL.createObjectURL(file)+'">'
		}

		function apercuEdit(event){
			let file = event.target.files[0]
			document.querySelector("#imgAperEdit").innerHTML = '<img width="120px;" height="120px;" src="'+URL.createObjectURL(file)+'">'
		}
		function clearForm(){
			let form = document.querySelector('#formEdit');
			$(form)[0].reset();
		}
	</script>
<?= $this->endSection('scripts') ?>