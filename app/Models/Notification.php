<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable=['to_id','from_id','type','ref','message'];
    protected $appends=['route_link','notification_name'];
    public function getRouteLinkAttribute(){
        switch($this->type){
            case config('notifications.notification_type.PROJECT_INVITATION'):
            case config('notifications.notification_type.PROJECT_HIRED'):
                return 'talent/project/'.$this->ref.'?is_read='.$this->id;
                break;
            case config('notifications.notification_type.PROJECT_ACCEPTED'):
                return 'client/project/'.$this->ref.'?is_read='.$this->id;
                break;
            case config('notifications.notification_type.PROJECT_REJECTED'): 
                return 'client/project/'.$this->ref.'?is_read='.$this->id;
                break;

            case 5:   
            case 6:
            case 7:
            case 8:
            case 9: 
            case 10:
                return 'talent/test_status/?is_read='.$this->id;
                break;

                default:
                return '';
        }
    }

    public function getNotificationNameAttribute(){
        switch($this->type){
            case config('notifications.notification_type.PROJECT_INVITATION'):
                    return 'Project Invitation';
                    break;
            case config('notifications.notification_type.PROJECT_HIRED'):
                return 'Project Hired';
                break;
            case config('notifications.notification_type.PROJECT_ACCEPTED'):
                return 'Project Accepted';
                break;
            case config('notifications.notification_type.PROJECT_REJECTED'): 
                return 'Project Rejected';
                break;
            case 5:  
                return 'Profile Screening ';
                break; 
            case 6:
                return 'Aptitute Test';
                break; 
            case 7:
                return 'Aptitute Status';
                break;
            case 8:
                return 'Techincal Test';
                break;
            case 9: 
                return 'Techincal Status';
                break;
            case 10:   
                return 'Interview Status';
               break; 
            default:
                return 'Default';
        }
    }
}
