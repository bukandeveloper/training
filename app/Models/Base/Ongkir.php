<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 16 Jun 2019 04:46:10 +0900.
 */

namespace App\Models\Base;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Ongkir
 * 
 * @property int $id
 * @property string $kota
 * @property int $ongkir
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models\Base
 */
class Ongkir extends Eloquent
{
	protected $casts = [
		'ongkir' => 'int'
	];
}
