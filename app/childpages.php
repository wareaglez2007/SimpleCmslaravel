<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class childpages extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'pages_id',
        'parent_page_id'
    ];



}
