<?php namespace Exults\Logs;

use Illuminate\Database\Eloquent\Model;

class UserLogSplit extends Model {

	protected $table = 'user_logs_split';

	public $timestamps = false;

	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
		$this->table = config('userlogs.user_logs_split_table');
	}

}