<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DirectionController extends Controller
{

  public function index(Request $request)
  {
      $role = session('role_id');
      $users = session('user_name');

      $abit_branch = DB::table('abit_branch')->get();
      $form_obuch  = DB::table('abit_formObuch')->get();
      $stlevel     = DB::table('abit_stlevel')->get();
      $predmet_vuz = DB::table('abit_predmets')
      ->select('abit_predmets.id as Pid','abit_stlevel.name as StName', 'abit_predmets.name as Predmetname')
      ->leftjoin('abit_stlevel', 'abit_stlevel.id', '=', 'abit_predmets.stlevel_id')
      ->where('is_vuz', 'T')->orderby('abit_predmets.name', 'asc')->get();

      $abit_group  = DB::table('abit_group as ag')
                      ->leftjoin('abit_facultet as af', 'af.id', 'ag.fk_id')
                      ->leftjoin('abit_branch as ab', 'ab.id', 'af.branch_id')
                      ->leftjoin('abit_formObuch as afo', 'afo.id', 'ag.fo_id')
                      ->leftjoin('abit_stlevel as ast', 'ast.id', 'ag.st_id')
                      ->select('ag.*', 'af.name as facult_name', 'ab.short_name as branch_name', 'afo.name as form_obuch', 'ast.name as stlevel_name')
                      ->orderby('ab.name','asc')
                      ->orderby('af.name','asc')
                      ->orderby('ag.name','asc')
                      ->get();

      return view('DirectionPage.direction',
          [
              'title'         => 'Направление',
              'role'          => $role,
              'username'      => $users,
              'abit_branch'   => $abit_branch,
              'form_obuch'    => $form_obuch,
              'stlevel'       => $stlevel,
              'predmet_vuz'   => $predmet_vuz,
              'abit_group'    => $abit_group

          ]);
  }
    public function get_facultet(Request $request)
    {
        $abit_facultet = DB::table('abit_facultet')->where('branch_id', $request->abit_branch)->orderby('name', 'asc')->get();
        $data = '<option value="-1">Выберите элемент</option>';
        foreach($abit_facultet as $fac) $data .= '<option value="'.$fac->id.'">'.$fac->nick.'</option>';
        return $data;
    }

    public function save(Request $request)
    {
        if (trim($request->abit_group_name) != '')
        {
            if ($request->agid == -1)
            {
                $agid = DB::table('abit_group')->insertGetId(
                    [
                        'name'  => $request->abit_group_name,
                        'nick'  => $request->abit_nick,
                        'fo_id' => $request->abit_fo_id,
                        'fk_id' => $request->abit_facultet,
                        'st_id' => $request->abit_oku,
                        'minid' => $request->abit_shifr
                    ]
                );

                if (count($request->predmen_id) > 0) {

                    foreach($request->predmet_id as $pid)
                    {
                        DB::table('abit_examenGroup')->insert(['predmet_id' => $pid, 'group_id' => $agid]);
                    }
                }
            }
            else
            {
                DB::table('abit_group')->where('id', $request->agid)->update(
                    [
                        'name'  => $request->abit_group_name,
                        'nick'  => $request->abit_nick,
                        'fo_id' => $request->abit_fo_id,
                        'fk_id' => $request->abit_facultet,
                        'st_id' => $request->abit_oku,
                        'minid' => $request->shifr
                    ]
                );
                DB::table('abit_examenGroup')->where('group_id', $request->agid)->delete();
                if (count($request->predmen_id) > 0) {
                    foreach($request->predmet_id as $pid)
                    {
                        DB::table('abit_examenGroup')->insert(['predmet_id' => $pid, 'group_id' => $request->agid]);
                    }
                }
            }
        }
        return back();
    }
}
