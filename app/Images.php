<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Images extends Model
{
    use SoftDeletes;

    protected $fillable = [
          'image_name',
          'image_hash',
          'pages_id',
           'path_to',
           'alttext',
           'caption',

          ];
        protected $guarded = [];

}
