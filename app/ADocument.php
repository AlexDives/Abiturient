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
			$select_old = ADocument::where([
				['pers_id', session('person_id')],
				['doc_id', $t]
			])->first();
			if($select_old != null ){

			}else{
				$query = new ADocument;
				$query->pers_id = session('person_id');
				$query->doc_id = $t;
				$query->save();
			}
		}
	}
}
