<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TalentAptitudeTest extends Model
{
    protected $fillable=['user_id','talent_id','test_id'];

    public function createTest($data){
        return self::create([
            'user_id'=>$data['user_id'],
            'talent_id'=>$data['talent_id'],
            'test_id'=>$data['test_id']
        ]);
    }
}
