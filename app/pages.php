<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class pages extends Model
{

    use SoftDeletes;

    //protected $dateFormat = 'r';
    /**
     * Get the phone record associated with the user.
     */
    public function page_slugs()
    {
        return $this->hasOne('App\page_slugs');
    }
    public function childPages(){
        return $this->hasMany('App\childpages', 'pages_id');
    }

    //

     protected $fillable = [
    // 'published',
      'title',
      'subtitle',
       'description',
      'owner',
      'publish_start_date',
      'active'
    //   'publish_start_date',
    //   'publish_end_date'
      ];
    protected $guarded = [];
}
