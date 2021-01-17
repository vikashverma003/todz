<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    protected $fillable=['name'];

    public function getAll()
	{
		return self::orderBy('id','desc')->paginate(10);
	}
	public function createCategory($data)
	{
		return self::insert([
         	'name'=>$data['name']
        ]);
	}
	public function getById($id)
	{
		return self::where('id',$id)->first();
	}
	public function updateCategory($data,$id)
	{
		return self::where('id',$id)->update([
			'name'=>$data['name']
		]);
	}
}
