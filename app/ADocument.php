<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ADocument extends Model
{
	protected $table = 'abit_document';
	public $timestamps = false;

	public static function InsertDoc($string){

		$array = explode(",", $string);

		foreach($array as $t){
			$query = new ADocument;
			$query->pers_id = session('person_id');
			$query->doc_id = $t;
			$query->save();
		}

	}
}
