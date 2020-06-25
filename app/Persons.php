<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persons extends Model
{
  protected $table = 'persons';
  public $timestamps = false;

  //=============== ТАБЛИЦА АБИТУРИЕНТОВ ================================//
  public static function DashboardTable(){
    //$tkt = APersPriv::select('id as ctt')->whereRaw('abit_persPrivilege.pers_id', 'persons.id')->count();

    $item_abit = Persons::
    selectRaw(
      'distinct(persons.id) as id_Abit, persons.famil as FirstName,
      persons.name as Name, persons.otch as LastName,
      persons.email, persons.phone_one as PhoneOne, persons.phone_two as PhoneTwo,
      (select count(ap.id) from abit_persPrivilege ap
          where ap.pers_id = persons.id) as countPriv, persons.is_checked as Checked'
      )
      ->join('abit_statements', 'abit_statements.person_id', '=', 'persons.id')
      ->join('abit_group', 'abit_group.id', '=', 'abit_statements.group_id')
      ->join('abit_facultet', 'abit_facultet.id', '=', 'abit_group.fk_id')
      ->join('user_roles', 'user_roles.abit_branch_id', '=', 'abit_facultet.branch_id')
      ->where('persons.pers_type', 'a')
      ->where('persons.famil','<>', '')
      ->where('persons.email','<>', '')
      ->where('user_roles.user_id', session('user_id'))
      //->whereNull('abit_statements.date_return')
      ->orderBy('FirstName', 'ASC')
      ->get();
      $k = [];
      $i = 0;
      foreach ($item_abit as $key) {
        if($key->countPriv != 0) $privilage = '&#10003;';
        else   $privilage = '';
        if($key->Checked === 'T' ) $Checked = '&#10003;';
        else $Checked = '';
          $k +=[$i =>[$key->id_Abit,
                      $Checked,
                      $key->FirstName.' '.$key->Name.' '.$key->LastName, //FIO
                      $privilage,
                      $key->PhoneOne,
                      $key->PhoneTwo,
                      $key->email,'']];
          $i++;
      }

      $arr=array
      (
          "data" => $k
      );

      return $arr;
  }

  //=============== БОКОВАЯ ПАНЕЛЬ ================================//
  public static function DashboardSidebar($id_person){
    $query = Persons::
        select
        (
            'persons.famil as FirstName',
            'persons.name as Name',
            'persons.otch as LastName',
            'persons.photo_url as Avatar',
            'persons.birthday as Birthday'
        )
       ->where('id',$id_person)
        ->first();

    $arr = [
      "FirstName" => $query->FirstName,
      "Name" => $query->Name,
      "LastName" => $query->LastName,
      "Avatar" => $query->Avatar,
      "Birthday" => date("d.m.Y", strtotime($query->Birthday))
    ];

    return $arr;
  }

  //=============== ТАБЛИЦА ЭКЗАМЕНОВ АБИТУРИЕНТА ================================//
  public static function DashboardPersonsExams($id_person){
    $query = AExamsCard::
        select
        (
          'abit_predmets.name as Predmet',
          'abit_examCard.date_exam as DateExam',
          'abit_examCard.ball as Ball'
        )
        ->leftjoin('abit_examenGroup', 'abit_examenGroup.id', '=', 'abit_examCard.exam_id')
        ->leftjoin('abit_predmets', 'abit_predmets.id', '=', 'abit_examenGroup.predmet_id')
        ->leftjoin('abit_statements', 'abit_statements.id', '=', 'abit_examCard.state_id')
        ->where('abit_statements.person_id', $id_person)
        ->distinct()
        ->get();

        $k = [];
        $i = 0;

        foreach ($query as $key) {

            $k +=[$i =>[$key->Predmet,
            $key->DateExam != null ? date("d.m.Y", strtotime($key->DateExam)) : '',
                        $key->Ball,
                        ]];
            $i++;
        }

        $arr=array
        (
            "data" => $k
        );

        return $arr;
  }


  //=============== ТАБЛИЦА ПОДАННЫХ АБИТУРИЕНТОМ ЗАЯВЛЕНИЙ ================================//
  public static function DashboardPersonsStatment($id_person){
    $query = AStatments::
        select
        (
            'abit_statements.shifr_statement as shifr',
            'abit_group.name as SpecName',
            'abit_statements.date_return as DateReturn'
        )
        ->leftJoin('abit_group', 'abit_group.id', '=', 'abit_statements.group_id')
        ->where('abit_statements.person_id',$id_person)
        ->get();

        $k = [];
        $i = 0;

        foreach ($query as $key) {

            $k +=[$i =>[$key->shifr,
                        $key->SpecName,
                        $key->DateReturn != null ? date("d.m.Y", strtotime($key->DateReturn)) : '']];
            $i++;
        }

        $arr=array
        (
            "data" => $k
        );

        return $arr;
  }

}
