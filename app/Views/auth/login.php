<?= $this->extend('layouts/template') ?>
<?= $this->section('content') ?>
<div class="container" style="margin-top: 10%;">
		<div class="row justify-content-center">
			<div class="col-md-4">

				<!-- Affichage du message de succès ou erreur -->
				<?php if (!empty(session()->getFlashdata('error'))): ?>
					<div class="alert alert-warning mb-3" role="alert">
						<strong>Attention ! </strong> <?= session()->getFlashdata('error') ?>
					</div>
				<?php endif ?>
				<?php if (!empty(session()->getFlashdata('success'))): ?>
					<div class="alert alert-success mb-3" role="alert">
						<strong>Félicitation ! </strong> <?= session()->getFlashdata('success') ?>
					</div>
				<?php endif ?>

				<h4>Connexion</h4><hr>
				<form action="<?= base_url('login') ?>" method="POST">
					<?= csrf_field() ?>

					<div class="mb-3">
						<div class="input-group">
				          <input type="text" name="email" class="form-control" id="email" placeholder="Entrer l'adresse email" value="<?= set_value('email') ?>">
				          <div class="input-group-append">
				            <div class="input-group-text">
				              <span class="fas fa-envelope"></span>
				            </div>
				          </div>
				        </div>
				        <span class="text-danger"><?= isset($validation) ? display_error($validation, 'email') : '' ?></span>
			        </div>
			        <div class="mb-3">
				        <div class="input-group">
				          <input type="password" name="password" class="form-control" id="password" placeholder="Entrer le mot de passe" value="<?= set_value('password') ?>">
				          <div class="input-group-append">
				            <div class="input-group-text">
				              <span class="fas fa-lock"></span>
				            </div>
				          </div>
				        </div>
				        <span class="text-danger"><?= isset($validation) ? display_error($validation, 'password') : '' ?></span>
			        </div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Connexion</button>
					</div>
					<br>
					<a href="<?= base_url('inscription') ?>">Vous n'avez pas encore un compte ?</a>
				</form>
			</div>
		</div>
	</div>
<?= $this->endSection() ?>