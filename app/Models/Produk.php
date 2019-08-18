<?php

namespace App\Models;

class Produk extends \App\Models\Base\Produk
{
	protected $fillable = [
		'kode_produk',
		'nama',
		'berat',
		'qty',
		'deskripsi',
		'kategori_id',
		'admin_id'
	];
}
