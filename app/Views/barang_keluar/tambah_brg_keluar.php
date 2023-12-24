<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<section class="content">
	<div class="container-fluid">

		<!-- validasi -->
		<?php if (session()->getFlashdata('errors')) : ?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Terjadi Kesalahan Inputan </strong>
				<?= session()->getFlashdata('errors'); ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		<?php endif; ?>
		<!-- end validasi -->

		<div class="card card-primary">
			<div class="card-body">
				<form action="<?= base_url('barang_keluar/simpan'); ?>" method="POST">
					<?= csrf_field(); ?>
					<div class="form-row">
						<div class="col">
							<label class="col-form-label">Nama Barang </label>
							<select name="id_barang" class="form-control">
								<option value="">-- Pilih Barang --</option>
								<?php foreach ($barang as $brg) : ?>
									<option value="<?= $brg['id_barang']; ?>" <?= set_select('id_barang', $brg['id_barang']); ?>>
										<?= $brg['nama_barang'] . ' - ' . $brg['nama_kategori']; ?>
									</option>
								<?php endforeach; ?>
							</select>

						</div>
					</div>
					<div class="form-row mt-2">
						<div class="col">
							<label class="col-form-label">Jumlah Keluar </label>
							<input type="number" min="0" name="jumlah_keluar" id="jumlah_keluar" class="form-control" autocomplete="off" value="<?= old('jumlah_keluar'); ?> " onchange="calculateTotal()">
						</div>
						<div class=" col">
							<label class="col-form-label">Harga Satuan </label>
							<input type="number" min="0" name="harga_satuan" id="harga_satuan" class="form-control" autocomplete="off" value="<?= old('harga_satuan'); ?>" onchange="calculateTotal()">
						</div>
					</div>

					<div class="form-row mt-2">
						<div class="col">
							<label class="col-form-label">Total Harga </label>
							<input type="number" readonly min="0" id="total_harga" name="total_harga" class="form-control" autocomplete="off">
						</div>
						<div class="col">
							<label class="col-form-label">Tanggal Keluar </label>
							<input type="date" min="0" name="tgl_keluar" class="form-control" autocomplete="off" value="<?= old('tgl_keluar'); ?>">
							<input type="hidden" name="disimpan_oleh" value="<?= session()->get('nama_lengkap'); ?>">
						</div>
					</div>

					<div class="mt-3">
						<button type="submit" class="btn btn-primary btn-sm">Simpan Data</button>

						<?php if (session()->get('role') == 'Owner') : ?>
							<a class="btn btn-secondary btn-sm" href="<?= base_url('barang_keluar'); ?>">Kembali</a>
						<?php endif ?>

						<?php if (session()->get('role') == 'Karyawan') : ?>
							<a class="btn btn-secondary btn-sm" href="<?= base_url('barang_keluar/krw'); ?>">Kembali</a>
						<?php endif ?>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<?= $this->endSection(); ?>

<?= $this->section('script'); ?>

<script>
	function calculateTotal() {
		var jumlah_keluar = parseInt(document.getElementById("jumlah_keluar").value);
		var harga_satuan = parseInt(document.getElementById("harga_satuan").value);
		var total_harga = jumlah_keluar * harga_satuan;

		if (!isNaN(total_harga)) {
			document.getElementById("total_harga").value = total_harga.toFixed(2);
		} else {
			document.getElementById("total_harga").value = "";
		}
	}
</script>

<?= $this->endSection(); ?>