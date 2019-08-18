<?php

/**
 * Created by Reliese Model.
 * Date: Sun, 16 Jun 2019 04:46:44 +0900.
 */

namespace App\Models\Base;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MembersLoginHistory
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
class MembersLoginHistory extends Eloquent
{
	protected $dates = [
		'login_at',
		'failed_login_at'
	];
}
