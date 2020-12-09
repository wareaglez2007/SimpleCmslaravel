<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageImages extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [

        'pages_id',
        'image_id',
        'deleted_at'

        ];
      protected $guarded = [];

      public function Pages(){
        return $this->hasMany('App\Pages', 'pages_id');
    }
    public function Images(){
        return $this->hasMany('App\Images', 'image_id');
    }
}
