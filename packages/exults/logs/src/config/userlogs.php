<?php

/* THIS FILE IS PART OF Exults\Logs */

return [
    'user_logs_table' => 'user_logs',
    'user_logs_request_table' => 'user_logs_request',
    'user_logs_split_table' => 'user_logs_split',
    'user_logs_time_table' => 'user_logs_time',

    //IF LOGGING IN FROM A USER WITH PERMISSIONS TO LOGIN TO ANY ACCOUNT
    //THIS IS THE Session::get('variable') THAT WILL GET THE ORIGINAL USER
    'orig_user' => 'currentUserId',

    //DON'T LOG THESE PATHS
    'path_not' => [
        '/files/exults/favicon-1435632569.JPG'
    ]
];