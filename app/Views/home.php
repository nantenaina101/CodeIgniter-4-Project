<?= $this->extend('layouts/template') ?>
<?= $this->section('content') ?>
<div class="container" style="margin-top: 5%;">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<h4><?= $title ?></h4><hr>
				<table class="table table-bordered table-sm text-center">
					<thead>
						<tr>
							<th>Nom</th>
							<th>Email</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?= ucfirst($userInfo['name']) ?></td>
							<td><?= $userInfo['email'] ?></td>
							<td><a href="<?= base_url('logout') ?>" class="btn btn-sm btn-danger">Déconnexion</a></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<?= $this->endSection() ?>