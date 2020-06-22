<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Mail;
use Validator;
use App\ATypDoc;
use App\ADocument;
class ScanController extends Controller
{

    // ----------------- ЗАГРУЗКА ШАБЛОНА ----------------------------------//
    public function index(Request $request)
    {
        $role = session('role_id');
        $users = session('user_name');
        $typDoc = ATypDoc::Get_type_doc();

        return view('ScanPhotoPage.scan_photo',
            [
                'title' => 'Сканирование фотографий',
                'role' => $role,
                'username' => $users,
                'typDoc' => $typDoc

            ]);
    }

    public function Upload_Scan_Photo(Request $request){
      $images = [];
      if ($request->hasFile('file')) {
        $attach = [];
        $i = 0;
       foreach($request->file('file') as $key => $image){
           
        if ($image->isValid()){
         $max_size = (int)ini_get('upload_max_filesize') * 1000;
         $validator = Validator::make($request->all(), [
         'file '=> 'image',
         'file.*' => 'mimetypes:image/jpeg,image/png,image/gif,application/pdf'. '|max:' . $max_size,
         ]);
        }
         $user_folder = session('person_id');
         $filename = $image->getClientOriginalName();
         Storage::putFileAs('public/abit_documents/'.$user_folder, $image, $filename);
         $attach += [
            $i => 'https://abit.ltsu.org/abit_documents/'.$user_folder.'/'.$filename
         ];
         $i++;
        }
        ScanController::sendMail(explode(",", $request->typ_doc), $attach);
        ADocument::InsertDoc($request->typ_doc);
       }
    }

    public function sendMail($docs, $attach)
    {
        $persons = DB::table('persons')->where('id', session('person_id'))->first();
        $docss = [];
        foreach ($docs as $doc) {
            $docss += [
                $doc => DB::table('abit_typeDoc')->where('id', $doc)->first()->name
            ];
        }
        
        Mail::send('MailsTemplate.MailScans', ['person' => $persons, 'docs' => $docss], function ($message) use ($persons, $attach) {
            $message->from('asu@ltsu.org', 'Информация с сайта abit.ltsu.org');
            $message->to('abiturient@ltsu.org')->subject('Скан-копии документов '.$persons->famil.' '.$persons->name.' '.$persons->otch);

            foreach ($attach as $a) {
                $message->attach($a);
            }
        }); 
    }
}
