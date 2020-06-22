<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ATypDoc extends Model
{
  protected $table = 'abit_typeDoc';
  public $timestamps = false;

  public static function Get_type_doc(){
   $query = ATypDoc::all();
   return $query;
  }
}
