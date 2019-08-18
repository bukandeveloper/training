<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 08 Aug 2019 10:10:08 +0900.
 */

namespace App\Models\Base;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Admin
 * 
 * @property int $id
 * @property int $is_online
 * @property string $email
 * @property string $password
 * @property string $name
 * @property bool $is_super
 * @property string $alamat
 * @property string $telp
 * @property \Carbon\Carbon $last_access
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $remember_token
 * 
 * @property \Illuminate\Database\Eloquent\Collection $kategories
 * @property \Illuminate\Database\Eloquent\Collection $members
 * @property \Illuminate\Database\Eloquent\Collection $mereks
 * @property \Illuminate\Database\Eloquent\Collection $news
 * @property \Illuminate\Database\Eloquent\Collection $pages
 * @property \Illuminate\Database\Eloquent\Collection $produks
 *
 * @package App\Models\Base
 */
class Admin extends Eloquent
{
	protected $casts = [
		'is_online' => 'int',
		'is_super' => 'bool'
	];

	protected $dates = [
		'last_access'
	];

	public function kategories()
	{
		return $this->hasMany(\App\Models\Kategory::class);
	}

	public function members()
	{
		return $this->hasMany(\App\Models\Member::class);
	}

	public function mereks()
	{
		return $this->hasMany(\App\Models\Merek::class);
	}

	public function news()
	{
		return $this->hasMany(\App\Models\News::class);
	}

	public function pages()
	{
		return $this->hasMany(\App\Models\Page::class);
	}

	public function produks()
	{
		return $this->hasMany(\App\Models\Produk::class);
	}
}
