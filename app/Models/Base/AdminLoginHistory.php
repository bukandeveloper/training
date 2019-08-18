<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 16 Jun 2019 04:45:15 +0900.
 */

namespace App\Models\Base;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class AdminLoginHistory
 * 
 * @property int $id
 * @property \Carbon\Carbon $login_at
 * @property string $email
 * @property string $ip_address
 * @property \Carbon\Carbon $failed_login_at
 * @property string $not_exist_user
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models\Base
 */
class AdminLoginHistory extends Eloquent
{
	protected $dates = [
		'login_at',
		'failed_login_at'
	];
}
