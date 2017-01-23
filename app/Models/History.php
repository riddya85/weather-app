<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{

    protected $dates = ['created_at', 'updated_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'user_id', 'lng','lat',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function getItems($count = 10) {
        $allItems = $this->take($count)->orderBy('id','DESC')->get();

        return $allItems;
    }
    
    public function getUserItems($userId,$count = 5) {
        $allItems = $this->where('user_id',$userId)->orderBy('id','DESC')->limit($count)->get();

        return $allItems;
    }
    
    public function getMoreItems($lastId,$count = 5) {
        $allItems = $this->where('id','<',$lastId)->orderBy('id','DESC')->limit($count)->get();

        return $allItems;
    }

    public function getMoreUserItems($userId,$lastId,$count = 5) {
        $allItems = $this->where('id','<',$lastId)->where('user_id',$userId)->orderBy('id','DESC')->limit($count)->get();

        return $allItems;
    }
}
