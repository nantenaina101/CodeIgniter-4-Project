<?= $this->extend('layout/dashboard-layout') ?>
<?= $this->section('content') ?>

	<div class="container">
		<div class="row">
			<div class="col-md-6 offset-md-3">
				<form action="<?= route_to('email.send') ?>" method="POST">
					<?= csrf_field() ?>
					
					<!-- Display error or success message -->
					<?php if (!empty(session()->getFlashdata('error'))): ?>
						<div class="alert alert-warning" role="alert">
						    <strong>Attention ! </strong> <?= session()->getFlashdata('error') ?>
						</div>
					<?php endif ?>
					<?php if (isset($success)): ?>
						<div class="alert alert-success" role="alert">
						    <strong>Félicitation ! </strong> <?= $success ?>
						</div>
					<?php endif ?>
					<div class="form-group">
						<label for="name">Nom</label>
						<input type="text" class="form-control" name="name" id="name" placeholder="Votre nom" value="<?= set_value('name') ?>">
						<span class="text-danger"><?= (isset($validation) && $validation->hasError('name')) ? $validation->getError('name') : '' ?>
						</span>
					</div>
					<div class="form-group">
						<label for="fname">Prénoms</label>
						<input type="text" class="form-control" name="fname" id="fname" placeholder="Votre prénoms" value="<?= set_value('fname') ?>">
						<span class="text-danger"><?= (isset($validation) && $validation->hasError('fname')) ? $validation->getError('fname') : '' ?>
						</span>
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="text" class="form-control" name="email" id="email" placeholder="Votre email" value="<?= set_value('email') ?>">
						<span class="text-danger"><?= (isset($validation) && $validation->hasError('email')) ? $validation->getError('email') : '' ?>
						</span>
					</div>
					<div class="form-group">
						<label for="sujet">Sujet</label>
						<input type="text" class="form-control" name="sujet" id="sujet" placeholder="Votre sujet" value="<?= set_value('sujet') ?>">
						<span class="text-danger"><?= (isset($validation) && $validation->hasError('sujet')) ? $validation->getError('sujet') : '' ?>
						</span>
					</div>
					<div class="form-group">
						<label for="name">Message</label>
						<textarea name="message" id="message" rows="3" cols="3" class="form-control"><?= set_value('message') ?></textarea>
						<span class="text-danger"><?= (isset($validation) && $validation->hasError('message')) ? $validation->getError('message') : '' ?>
						</span>
					</div>
					<button type="submit" class="btn btn-primary btn-block mb-3">Envoyer</button>
				</form>
			</div>
		</div>
	</div>

<?= $this->endSection() ?>