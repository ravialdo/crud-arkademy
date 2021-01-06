<?php

namespace App\Http\Livewire;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Produk as ProdukBarang;

class Produk extends Component
{
	use WithPagination;
	
	public $nama_produk, $harga, $jumlah, $keterangan, $selectedId, $search;
	public $edit_nama_produk, $edit_harga, $edit_jumlah, $edit_keterangan;
	public $create = false, $edit = false;
	
	protected $rules = [
		'nama_produk' => 'required',
		'harga' => 'required',
		'jumlah' => 'required',
		'keterangan' => 'required'
	];
	
	protected $messages = [
		'required' => ':attribute tidak boleh kosong'
	];
	
	protected $paginationTheme = 'bootstrap';
	protected $queryString = ['search'];
	
	protected $listeners = [
		'render', 'destroy'
	];
	
	/**
     *
     * Tambah Data
     *
      * @return store()
     **/
	public function store(){
		$this->validate();
		
		ProdukBarang::create([
			'nama_produk' => $this->nama_produk,
			'harga' => $this->harga,
			'jumlah' => $this->jumlah,
			'keterangan' => $this->keterangan
		]);
		
		$this->reset();
		alert()->success('Berhasil!', 'Data telah disimpan');
	}
	/**
	*
	* Edit Data
	*
	* @return edit ()
	*
	**/
	public function edit($id){
		$data = ProdukBarang::whereId($id)->first();
		$this->edit_nama_produk = $data->nama_produk;
		$this->edit_harga = $data->harga;
		$this->edit_jumlah = $data->jumlah;
		$this->edit_keterangan = $data->keterangan;
		
		$this->selectedId = $data->id;
		$this->edit = true;
	}
	/**
	*
	* Hapus Data
	*
	* @return destroy ()
	*
	**/
	public function update()
	{
		$this->validate([
			'edit_nama_produk' => 'required',
			'edit_harga' => 'required',
			'edit_jumlah' => 'required',
			'edit_keterangan' => 'required'
		],[
			'edit_nama_produk.required' => 'nama produk tidak boleh kosong',
			'edit_harga.required' => 'harga tidak boleh kosong',
			'edit_jumlah.required' => 'jumlah tidak boleh kosong',
			'edit_keterangan.required' => 'keterangan tidak boleh kosong'
		]);
		
		ProdukBarang::whereId($this->selectedId)->update([
			'nama_produk' => $this->edit_nama_produk,
			'harga' => $this->edit_harga,
			'jumlah' => $this->edit_jumlah,
			'keterangan' => $this->edit_keterangan
		]);
		
		$this->reset();
		alert()->success('Berhasil!', 'Data telah di edit');
	}
	
	/**
	*
	* Hapus Data
	*
	* @return destroy ()
	*
	**/
	public function destroy($id)
	{
		ProdukBarang::find($id)->delete();
		alert()->success('Berhasil!', 'Data telah dihapus');
	     $this->emit('render');
	}
	
    public function render()
    {
	   $data = [
		   'produk' => ProdukBarang::where('nama_produk', 'like', "%$this->search%")
							->orderBy('id', 'desc')->paginate(10)
	   ];
	
        return view('livewire.produk', $data)->layout('layouts.app')->slot('main');
    }
}
