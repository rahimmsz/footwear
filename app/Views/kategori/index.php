<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<section class="content">
	<div class="container-fluid">
		<a href="<?= base_url('/kategori/tambah'); ?>" class="btn btn-sm btn-primary mb-4"><i class="fas fa-plus-circle mr-2"></i>
			Tambah Data
		</a>

		<?php if (session()->getFlashdata('pesan')) : ?>
			<div class="alert alert-success" role="alert">
				<?= session()->getFlashdata('pesan'); ?>
			</div>
		<?php endif ?>

		<div class="card">
			<div class="card-body">
				<div class="table-responsive-sm">
					<table id="example1" class="table table-bordered text-center table-sm" style="width:100%">
						<thead>
							<tr>
								<th scope="col">No</th>
								<th scope="col">Nama Kategori</th>
								<th scope="col">Aksi</th>
							</tr>
						</thead>
						<tbody>

							<?php $no = 1 ?>
							<?php foreach ($kategori as $ktg) : ?>
								<tr>
									<th><?= $no++; ?></th>
									<td><?= esc($ktg['nama_kategori']); ?> </td>
									<td>
										<a class="btn btn-warning btn-sm" href="<?= base_url('kategori/edit/' . $ktg['id_kategori']); ?>"><i class="fas fa-edit"></i></a>
										<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal<?= $ktg['id_kategori']; ?>">
											<i class="fas fa-trash"></i>
										</button>
									</td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>


<?php foreach ($kategori as $ktg) : ?>
	<div class="modal fade" id="modal<?= $ktg['id_kategori']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header justify-content-center">
					<h5 class="modal-title" id="staticBackdropLabel">Konfirmasi</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body text-center">
					<i class="fas fa-info-circle text-danger mb-4" style="font-size: 70px;"></i>
					<p>Apakah Anda Yakin untuk Menghapus <strong> <?= $ktg['nama_kategori']; ?></strong> ?</p>
					<form action="<?= base_url('kategori/' . $ktg['id_kategori']); ?>" method="POST">
						<?= csrf_field(); ?>
						<div class="modal-footer justify-content-center">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
							<input type="hidden" name="_method" value="DELETE">
							<button type="submit" class="btn btn-danger">Yakin</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php endforeach ?>
<?= $this->endSection(); ?>


<?= $this->section('script'); ?>
<script>
	$(function() {
		$("#example1").DataTable({
			responsive: true,
			lengthChange: true,
			autoWidth: false,
		});
	});
</script>
<?= $this->endSection(); ?>