<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 16 Jun 2019 04:46:28 +0900.
 */

namespace App\Models\Base;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class News
 * 
 * @property int $id
 * @property string $title
 * @property string $content
 * @property \Carbon\Carbon $publication_date
 * @property string $url
 * @property int $admin_id
 * @property int $kategori_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\Admin $admin
 * @property \App\Models\NewsKategory $news_kategory
 *
 * @package App\Models\Base
 */
class News extends Eloquent
{
	protected $casts = [
		'admin_id' => 'int',
		'kategori_id' => 'int'
	];

	protected $dates = [
		'publication_date'
	];

	public function admin()
	{
		return $this->belongsTo(\App\Models\Admin::class);
	}

	public function news_kategory()
	{
		return $this->belongsTo(\App\Models\NewsKategory::class, 'kategori_id');
	}
}
