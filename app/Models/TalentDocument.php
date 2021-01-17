<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TalentDocument extends Model
{
    protected $fillable= ['user_id','file_name','original_name','type'];
    protected $appends=['file_full_path','document_image'];
    public function getFileFullPathAttribute(){
        return env('APP_URL').'/'.env('FILE_UPLOAD_PATH').'/'.$this->file_name;
    }

    public function getDocumentImageAttribute(){
        $pi = pathinfo($this->file_name);
        $ext = $pi['extension'];
        switch($ext){
            case 'pdf':
                return env('APP_URL').'/web/images/pdf-icon.png';
                break;
            case 'doc':
            case 'docx':   
                return env('APP_URL').'/web/images/document-icon.png';
                break;
            default:
            return env('APP_URL').'/web/images/png-icon.png';

        }

    }
}
