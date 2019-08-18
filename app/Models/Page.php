<?php

namespace App\Models;

class Page extends \App\Models\Base\Page
{
	protected $fillable = [
		'judul',
		'konten',
		'admin_id'
	];
}
