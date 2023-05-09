<?= $this->extend('layout/dashboard-layout') ?>
<?= $this->section('content') ?>

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
				
<?= $this->endSection() ?>