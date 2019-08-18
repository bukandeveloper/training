<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 16 Jun 2019 04:46:59 +0900.
 */

namespace App\Models\Base;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class NewsKategory
 * 
 * @property int $id
 * @property string $kategori
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $news
 *
 * @package App\Models\Base
 */
class NewsKategory extends Eloquent
{
	public function news()
	{
		return $this->hasMany(\App\Models\News::class, 'kategori_id');
	}
}
