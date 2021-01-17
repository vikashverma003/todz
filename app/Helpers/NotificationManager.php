<?php
namespace App\Helpers;
use App\Repositories\NotificationRepository;
use Auth;

class NotificationManager {
    
    public function __construct(){
        $this->notification=new NotificationRepository();
    }
    public function get()
    {
        $currentUser=Auth::user();
        return $this->notification->showUserNotification($currentUser->id);
    }
    public function notificationCount(){
        $currentUser=Auth::user();
        return $this->notification->showUserNotificationCount($currentUser->id);
        
    }
    public function getAgoTime($date,$is_full=1){
        $timestamp = strtotime($date);
        return $this->get_timeago( $timestamp,$is_full );
    }

    public function checkPermission(string $permission){
        if(\Auth::guard('admin')->user()->is_super==1){
            return true;
        }else
        {
            $permission_id = \App\Models\Permission::where('title', $permission)->value('id');
            $permissions = \Auth::guard('admin')->user()->permissions()->pluck('permission_id')->toArray();
            if(in_array($permission_id, $permissions)){
                return true;
            }else{
                return false;
            }
        }
    }
    
    function get_timeago( $ptime ,$is_full){
        $etime = time() - $ptime;

        if( $etime < 1 )
        {
            return 'less than '.$etime.' second ago';
        }
        if($is_full==1){
        $a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
                    30 * 24 * 60 * 60       =>  'month',
                    24 * 60 * 60            =>  'day',
                    60 * 60             =>  'hour',
                    60                  =>  'minute',
                    1                   =>  'second'
        );
    }else{
        $a = array( 12 * 30 * 24 * 60 * 60  =>  'yr',
        30 * 24 * 60 * 60       =>  'mo',
        24 * 60 * 60            =>  'day',
        60 * 60             =>  'hr',
        60                  =>  'min',
        1                   =>  'sec'
);
    }

        foreach( $a as $secs => $str )
        {
            $d = $etime / $secs;

            if( $d >= 1 )
            {
                $r = round( $d );
               
                return $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' ago';
              
            }
        }
    }

}