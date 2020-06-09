<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persons extends Model
{
  protected $table = 'persons';
  public $timestamps = false;

  //=============== ТАБЛИЦА АБИТУРИЕНТОВ ================================//
  public static function DashboardTable(){
    $item_abit = Persons::
        select
        (
            'persons.id as id_Abit',
            'persons.famil as FirstName',
            'persons.name as Name',
            'persons.otch as LastName',
            'abit_typePrivilege.name as Privilegename',
            'persons.email',
            'persons.phone_one as PhoneOne',
            'persons.phone_two as PhoneTwo'

        )
       ->leftJoin('abit_persPrivilege', 'abit_persPrivilege.pers_id', '=', 'persons.id')
       ->leftJoin('abit_typePrivilege', 'abit_typePrivilege.id', '=', 'abit_persPrivilege.priv_id')
       ->where('persons.pers_type', 'a')
       ->get();

      $k = [];
      $i = 0;

      foreach ($item_abit as $key) {

          $k +=[$i =>[$key->id_Abit,
                      $key->FirstName.' '.$key->Name.' '.$key->LastName, //FIO
                      $key->Privilegename,
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
                        date("d.m.Y", strtotime($key->DateReturn))]];
            $i++;
        }

        $arr=array
        (
            "data" => $k
        );

        return $arr;
  }

}
