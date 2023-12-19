<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<section class="content">
	<div class="container-fluid">

		<div class="text-danger">
			<?= session()->getFlashdata('error'); ?>
		</div>

		<div class="row">
			<div class="col">
				<div class="card">
					<div class="card-body">
						<form method="POST" action="<?= base_url('/user/simpan'); ?>" enctype="multipart/form-data">
							<?= csrf_field(); ?>
							<div class="form-row">
								<div class="col">
									<label class="col-form-label">Nama Lengkap </label>
									<input type="text" name="nama_lengkap" class="form-control" autocomplete="off" value="<?= old('nama_lengkap'); ?>">
								</div>
							</div>

							<div class="form-group ">
								<label for="Nama">Username : </label>
								<input type="text" name="username" class="form-control" autocomplete="off" value="<?= old('username'); ?>">
							</div>
							<div class="form-group ">
								<label for="Nama">Password : </label>
								<input type="password" name="password" class="form-control" autocomplete="off" value="<?= old('password'); ?>">
							</div>

							<div class="form-group ">
								<label for="select-roles">Roles : </label>
								<select name="role" class="form-control">
									<option value="">-- Pilih Role --</option>
									<option value="Owner">Owner</option>
									<option value="Karyawan">Karyawan</option>
								</select>
							</div>
							<button type="submit" class="btn btn-primary">Simpan Data</button>
							<a href="<?= base_url('user'); ?>" class="btn btn-secondary"> Kembali </a>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<?= $this->endSection(); ?>