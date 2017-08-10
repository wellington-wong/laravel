<?php namespace Exults\Logs;

use Illuminate\Database\Eloquent\Model;

class UserLogRequest extends Model {

	protected $table;

	public $timestamps = false;

	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
		$this->table = config('userlogs.user_logs_request_table');
	}

}