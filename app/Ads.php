<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Ads extends Model
{
    //
    use SoftDeletes;
    protected $primaryKey ='a_id';
    public $timestamps = false;

}
