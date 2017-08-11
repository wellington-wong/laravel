<?php namespace Exults\Logs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class UserLog extends Model {

	protected $table;

	public $timestamps = true;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('userlogs.user_logs_table');
    }


    public static function logEnd() {

        $request = request();
        if ( null !== $request->get('__log_id') ) {
            $request_time = round(microtime(true) - LARAVEL_START, 2);
            UserLogTime::insert([
                'log_id' => $request->get('__log_id'),
                'seconds' => $request_time
            ]);
        }

    }

    
    public static function log() {

        $request = request();
        $user = $request->user();

        //DO NOT LOG THESE PATHS
        $path_not = config('userlogs.path_not');

        $u_id = !is_null($user) ? $user->id : 0;
        $path = $request->server('REQUEST_URI');
        $orig_user = Session::get( config('userlogs.orig_user'));

        if ( ! in_array($path, $path_not)) {
            $u = new UserLog();
            //$u->ip = ip2long($_SERVER['REMOTE_ADDR']);
            $u->user_id = !is_null($orig_user) ? $orig_user : $u_id;
            $u->as_user = $u_id;
            $u->route = $path;
            $u->method = $request->getMethod();
            $u->save();

            $request->merge(['__log_id' => $u->id]);

            //IF MOVE LOGS TO DIFFERENT DATABASE, MOVE THIS TO A JOB
            //new LogInfo($path, $_REQUEST, $u->id);
            UserLog::insertRequest( $request, $u->id );
            UserLog::insertSplit( $path, $u->id );
        }


    }

	/**
	 * 
	 * @param array $request
	 * @param int $log_id
	 */
    public static function insertRequest($request, $log_id ) {
        $ignoreKeys = ['laravel_session', '_ga', '_gat'];
        $rows = [];
        
        foreach ($request as $key => $value) 
        {
            if ( ! in_array($key, $ignoreKeys)) {
            	$value = json_encode($value);
                $rows[] = compact('log_id', 'key', 'value');
            }
        }
        
        if ( ! empty($rows)) {
        	UserLogRequest::insert($rows);
        }
    }

    /**
     * 
     * @param unknown $path
     * @param unknown $log_id
     */
    public static function insertSplit($path, $log_id) {

        $path = strstr($path, '?', true) ?: $path;
        $paths = array_filter(explode( "/", $path));
		$rows = [];
        
        foreach ($paths as $key => $p) {
            $rows[] = ['log_id'  => $log_id, 'path' => $p, 'position'  => $key];

            if ( strpos($p, '.') === false ) {
                if ( strpos($p, '-') !== false ) {
                    $ints = array_filter(preg_split("/-/", $p));
                    foreach ($ints as $int) {
                        $rows[] = ['log_id' => $log_id, 'path' => $int, 'position' => null];
                    }
                }
            } else {
                $filetype = substr( $p, strrpos($p, '.')+1 );
                $rows[] = ['log_id' => $log_id, 'path' => $filetype, 'position' => null];
            }
        }
        
        if ( ! empty($rows)) {
        	UserLogSplit::insert($rows);
        }
    }
}