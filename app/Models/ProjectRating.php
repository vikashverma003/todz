<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectRating extends Model
{
    protected $fillable=[
        'project_id',
		'rating',
		'feedback',
		'given_by_user_id',
		'rated_user_id',
		'rating_given_by',
		'created_at',
		'updated_at'
    ];
    public function givenByUser(){
        return $this->belongsTo('App\User','given_by_user_id','id');
    }
    public function ratedUser(){
        return $this->belongsTo('App\User','rated_user_id','id');
    }
    
    public function getById($id)
    {
        return self::where('id',$id)->first();
    }
    public function deleteReview($id)
    {
        return self::where('id',$id)->delete();
    }
    public function updateReview($data,$id)
    {
        return self::where('id',$id)->update([
            'rating' => $data['rating'],
            'feedback' => $data['feedback']
        ]);
    }
 }
