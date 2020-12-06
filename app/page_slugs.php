<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class page_slugs extends Model
{
    use SoftDeletes;
    protected $fillable = [
     'pages_id',
     'slug'
      ];
}
