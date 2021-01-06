<div>
	@include('sweetalert::alert')
	<div class="container-fluid">

		<div class="row justify-content-center">
			<div class="col-md-10">

				<div class="card mt-5">
					<div class="card-header">
						CRUD Arkademy
					</div>
					<div class="card-body">
						<h5 class="card-title">Data Produk</h5>
						<p class="card-text">
							Anda dapat mengelola data produk disini.
						</p>

						<div class="input-group flex-nowrap">
							<div class="input-group-prepend">
								<span class="input-group-text">
									<i class="fa fa-search"></i>
								</span>
							</div>
							<input type="text" wire:model="search" class="form-control" placeholder="Cari Produk..">
						</div>

						<div class="row mt-3">
							<div class="col-md-12" x-data="{open: @entangle('create')}">
								@if($edit == false)
								<button type="button" class="btn {{ $create == true ? 'btn-dark' : 'btn-primary' }}" @click="open=true">
									<i class="fa {{ $create == true ? 'fa-arrow-left' : 'fa-plus' }}"></i> {{ $create == true ? ' Tutup' : 'Tambah Data' }}
								</button>
								@endif

								<form class="mt-3" wire:submit.prevent="store" x-show="open" @click.away="open=false">

									<div class="form-group">
										<input type="text" wire:model.lazy="nama_produk" placeholder="Nama Produk" class="form-control {{ $errors->first('nama_produk') ? 'is-invalid' : '' }}" />
										<div class="invalid-feedback">
											{{ $errors->first('nama_produk') }}
										</div>
									</div>

									<div class="form-group">
										<input type="text" wire:model.lazy="harga" id="tambahHarga" placeholder="Rp. 0" class="form-control {{ $errors->first('harga') ? 'is-invalid' : '' }}" />
										<div class="invalid-feedback">
											{{ $errors->first('harga') }}
										</div>
									</div>

									<div class="form-group">
										<input type="number" wire:model.lazy="jumlah" placeholder="Jumlah" class="form-control {{ $errors->first('jumlah') ? 'is-invalid' : '' }}" />
										<div class="invalid-feedback">
											{{ $errors->first('jumlah') }}
										</div>
									</div>

									<div class="form-group">
										<textarea rows="3" placeholder="Keterangan" wire:model.lazy="keterangan" class="form-control {{ $errors->first('keterangan') ? 'is-invalid' : '' }}"></textarea>
										<div class="invalid-feedback">
											{{ $errors->first('keterangan') }}
										</div>
									</div>

									<button type="submit" class="btn btn-success">
										<i wire:target="store" wire:loading.remove class="fa fa-save"></i>
										<i wire:target="store" wire:loading class="fa fa-spinner fa-spin"></i> Simpan
									</button>

								</form>

							</div>
						</div>

						<div class="row">
							<div class="col-md-12" x-data="{edit: @entangle('edit')}">

								@if($edit == true)
								<button type="button" class="btn btn-dark" @click="edit=false">
									<i class="fa fa-arrow-left"></i> Tutup
								</button>
								@endif

								<form class="mt-3" wire:submit.prevent="update" x-show="edit" @click.away="edit=false">

									<div class="form-group">
										<input type="text" wire:model.lazy="edit_nama_produk" placeholder="Nama Produk" class="form-control {{ $errors->first('edit_nama_produk') ? 'is-invalid' : '' }}" />
										<div class="invalid-feedback">
											{{ $errors->first('edit_nama_produk') }}
										</div>
									</div>

									<div class="form-group">
										<input type="text" wire:model.lazy="edit_harga" placeholder="Rp. 0" class="form-control {{ $errors->first('edit_harga') ? 'is-invalid' : '' }}" />
										<div class="invalid-feedback">
											{{ $errors->first('edit_harga') }}
										</div>
									</div>

									<div class="form-group">
										<input type="number" wire:model.lazy="edit_jumlah" placeholder="Jumlah" class="form-control {{ $errors->first('edit_jumlah') ? 'is-invalid' : '' }}" />
										<div class="invalid-feedback">
											{{ $errors->first('edit_jumlah') }}
										</div>
									</div>

									<div class="form-group">
										<textarea rows="3" placeholder="Keterangan" wire:model.lazy="edit_keterangan" class="form-control {{ $errors->first('edit.keterangan') ? 'is-invalid' : '' }}"></textarea>
										<div class="invalid-feedback">
											{{ $errors->first('edit.keterangan') }}
										</div>
									</div>

									<button type="submit" class="btn btn-primary">
										<i wire:target="update" wire:loading.remove class="fa fa-edit"></i>
										<i wire:target="update" wire:loading class="fa fa-spinner fa-spin"></i> Edit
									</button>

								</form>

							</div>
						</div>

						<div class="table-responsive-sm mt-3">
							<table class="table table-bordered table-hover">
								<caption>
									@if(count($produk) != 0)
									Menampikan halaman ke {{ $produk->currentPage() }} dari {{ $produk->lastPage() }} halaman <br>
									@if($search)
									(di filter dari {{ App\Models\Produk::all()->count() }} total data)
									@endif
									@else
									Tidak ada data yang tersedia
									@endif
								</caption>
								<thead>
									<tr>
										<th scope="col">No</th>
										<th scope="col">Nama</th>
										<th scope="col">Harga</th>
										<th scope="col">Jumlah</th>
										<th scope="col">Keterangan</th>
										<th scope="col">Aksi</th>
									</tr>
								</thead>
								<tbody>

									@php $i=1; @endphp
									@foreach($produk as $val)
									<tr>
										<th scope="row">{{ $i }}</th>
										<td>{{ $val->nama_produk }}</td>
										<td>{{ $val->harga }}</td>
										<td>{{ $val->jumlah }}</td>
										<td>{{ $val->keterangan }}</td>
										<td class="text-center">
											<a href="#" class="btn btn-danger btn-sm mt-1" onclick="destroy({{ $val->id }})">
												<i class="fa fa-trash"></i>
											</a>

											<a href="#" class="btn btn-primary btn-sm mt-1" wire:click="edit({{ $val->id }})">
												<i class="fa fa-pen"></i>
											</a>
										</td>
									</tr>
									@php $i++ @endphp
									@endforeach
									@if(count($produk) == 0)
									<td colspan="6" class="text-center">Tidak ada data untuk ditampilkan!</td>
									@endif
								</tbody>
							</table>
							<div class="mt-1 py-3 table-responsive">
								{{ $produk->links('vendor.pagination.bootstrap-4') }}
							</div>
						</div>

					</div>
				</div>

			</div>
		</div>

	</div>
</div>

@push('scripts')
<script>
	const destroy = (id) => {
		Swal.fire({
			title: 'PERINGATAN!',
			text: "Yakin ingin menghapus data user?",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yakin',
			cancelButtonText: 'Batal',
		}).then((result) => {
			if (result.value) {
				Livewire.emit('destroy', id);
			}
		});
	}
</script>
@endpush