<?php
namespace App\Modules\Crm\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Modules\Crm\Http\Customer;
use App\Modules\Crm\Http\CustomerNote;
use App\Model\Config;
use App\Model\Role;
use App\Model\User;
use Auth;
use URL;
use Datatables;

use Session;

class NotesController extends Controller
{

    function index()
    {

        return view('crm::notes.index');
    }

    
    function getNote($id)
    {
        $note = CustomerNote::find($id);

        return json_encode($note);
    }

    function updateNote(Request $request)
    {
      //dd($request->all());

        $this->validate(
            $request,
            [
                'subject' => 'required',
                'source'     =>'required',
                'note'     =>'required'


            ]
        );

        $note = CustomerNote::find($request->note_id);
        $note->subject = $request->subject;
        $note->source = $request->source;
        $note->note = $request->note;
        $note->save();

        return json_encode(['success'=>'ok','msg'=>'Record updated successfully.']);
    }

    function changePinStatus(Request $request)
    {
        //dd($request->all());
        $id = $request->id;
        $pin_status = $request->pin_status;

        $note = CustomerNote::find($id);
        if ($pin_status == 'pin_in') {
            $note->pinned = 1;
        }
        if ($pin_status == 'pin_out') {
            $note->pinned = 0;
        }
        $note->save();

        $arr['success'] ='ok';
        $arr['msg'] ='Record updated successfully';
        return json_encode($arr);
        exit;
    }


    function changeArchiveStatus(Request $request)
    {
        //dd($request->all());
        $id = $request->id;
        $archive_status = $request->archive_status;

        $note = CustomerNote::find($id);
        if ($archive_status == 'archive_in') {
            $note->archived = 1;
             $note->pinned = 0;
        }
        if ($archive_status == 'archive_out') {
            $note->archived = 0;
        }

        $note->save();

        $arr['success'] ='ok';
        $arr['msg'] ='Record updated successfully';
        return json_encode($arr);
        exit;
    }


    function delete(Request $request)
    {
        //dd($request->all());
        $id = $request->id;

        $note = CustomerNote::find($id);

        $note->delete();

        $arr['success'] ='ok';
        $arr['msg'] ='Record deleted successfully';
        return json_encode($arr);
        exit;
    }

  

    function updateEditable(Request $request)
    {

        //dd($request->all());

        $id = $request->pk;
        $name = $request->name;
        $value = $request->value;
        $note = CustomerNote::find($id);

        if ($name=='subject') {
            $note->subject = $value;
            $note->save();
        }

        if ($name=='source') {
            $note->source = $value;
            $note->save();
        }

        if ($name=='note') {
            $note->note = $value;
            $note->save();
        }
    }
    
    function getNotesJson($type)
    {
        $global_date = $this->global_date;

        if ($type=='archived') {
            $archived = 1;
        }
        if ($type=='active') {
            $archived = 0;
        }
        if (!empty(Session::get('cust_id'))) {
            $notes = CustomerNote::with(['entered_by','customer'])->where('customer_id', Session::get('cust_id'))->orderBy('pinned', 'desc')->orderBy('updated_at', 'desc')->where('archived', $archived)->where('type', 'simple')->get();
        } else {
            $notes = CustomerNote::with(['entered_by','customer'])->orderBy('pinned', 'desc')->orderBy('updated_at', 'desc')->where('archived', $archived)->where('type', 'simple')->get();
        }

         //dd($notes);

         $notes_arr =[];

        foreach ($notes as $note) {
            $btn = ' <a data-target="#modal-edit-note" id="modaal"  data-id="'.$note->id.'" data-toggle="modal"><span class="fa  fa-edit pin-active"></span></a>';
            if ($note->pinned) {
                 $btn .= '&nbsp;&nbsp;<a onclick="change_pin_note('.$note->id.',\'pin_out\')"><span class="fa fa-thumb-tack pin-active"></span></a>';
            } else {
                $btn .= '&nbsp;&nbsp;<a onclick="change_pin_note('.$note->id.',\'pin_in\')"><span class="fa fa-thumb-tack pin-disabled"></span></a>';
            }


            if ($note->archived) {
                $btn .= ' &nbsp;&nbsp;<a onclick="change_archive_note('.$note->id.',\'archive_out\')"><i class="fa fa-archive pin-active"></i></a>';
            } else {
                $btn .= ' &nbsp;&nbsp;<a onclick="change_archive_note('.$note->id.',\'archive_in\')"><i class="fa fa-archive pin-disabled"></i></a>';
            }

              $btn .= '&nbsp;&nbsp;<a onclick="delete_note('.$note->id.')"><span class="fa  fa-close pin-disabled"></span></a>';

              $btn .= '&nbsp;&nbsp;<a data-target="#modal-edit-htable" id="modaal"  data-id="'.$note->id.'" data-toggle="modal"><span class="fa  fa-eye"></span></a>';


            $notes_arr[] = [
                        'id'         => $note->id,
                        'subject'    => '<a data-pk="'.$note->id.'" data-value="'.$note->subject.'" class="subject_editable">'.$note->subject.'</a>',
                        'source'     => '<button type="button" data-type="select2" data-pk="'.$note->id.'" class="btn bg-gray-active  btn-sm source" id="source" data-value="'.$note->source.'"><span>'.$note->source.'</span></button>',
                        'created_by' => $note->entered_by->f_name.' '.$note->entered_by->l_name,
                        'created_at' => date($global_date, strtotime($note->created_at)),
                        'detail' => $note->note,
                        'actions'    => ['options'=>['classes'=>'action_td'],
                                         'value'=>$btn]];
        }

        return json_encode($notes_arr);
    }


    function getExcelNotesJson($type)
    {
        $global_date = $this->global_date;

        if ($type=='archived') {
            $archived = 1;
        }
        if ($type=='active') {
            $archived = 0;
        }
        if (!empty(Session::get('cust_id'))) {
            $notes = CustomerNote::with(['entered_by','customer'])->where('customer_id', Session::get('cust_id'))->orderBy('pinned', 'desc')->orderBy('updated_at', 'desc')->where('archived', $archived)->where('type', 'excel')->get();
        } else {
            $notes = CustomerNote::with(['entered_by','customer'])->orderBy('pinned', 'desc')->orderBy('updated_at', 'desc')->where('archived', $archived)->where('type', 'excel')->get();
        }

         //dd($notes);

         $notes_arr =[];

        foreach ($notes as $note) {
            $btn = ' <a data-target="#modal-show-edit-excel-note" id="modaal"  data-id="'.$note->id.'" data-toggle="modal"><span class="fa  fa-edit pin-active"></span></a>';
            if ($note->pinned) {
                 $btn .= '&nbsp;&nbsp;<a onclick="change_pin_note('.$note->id.',\'pin_out\')"><span class="fa fa-thumb-tack pin-active"></span></a>';
            } else {
                $btn .= '&nbsp;&nbsp;<a onclick="change_pin_note('.$note->id.',\'pin_in\')"><span class="fa fa-thumb-tack pin-disabled"></span></a>';
            }


            if ($note->archived) {
                $btn .= ' &nbsp;&nbsp;<a onclick="change_archive_note('.$note->id.',\'archive_out\')"><i class="fa fa-archive pin-active"></i></a>';
            } else {
                $btn .= ' &nbsp;&nbsp;<a onclick="change_archive_note('.$note->id.',\'archive_in\')"><i class="fa fa-archive pin-disabled"></i></a>';
            }

              $btn .= '&nbsp;&nbsp;<a onclick="delete_note('.$note->id.')"><span class="fa  fa-close pin-disabled"></span></a>';

              $btn .= '&nbsp;&nbsp;<a data-target="#modal-show-edit-excel-note" id="modaal" class="view_edit_ht" data-id="'.$note->id.'" data-toggle="modal"><span class="fa  fa-eye"></span></a>';


            $notes_arr[] = [
                        'id'         => $note->id,
                         
                        'created_by' => $note->entered_by->f_name.' '.$note->entered_by->l_name,
                        'created_at' => date($global_date, strtotime($note->created_at)),
                          
                        'actions'    => ['options'=>['classes'=>'action_td'],
                                         'value'=>$btn]];
        }

        return json_encode($notes_arr);
    }

    function saveDataExcel(Request $request)
    {

        //dd($request->all());

        $note_obj = new CustomerNote;
        $note_obj->customer_id = $request->customer_id;
        $note_obj->type = 'excel';
        $note_obj->json_data = $request->htdata;
        $note_obj->created_by = Auth::user()->id;

        if ($note_obj->save()) {
            $arr['success'] = 'yes';
            return json_encode($arr);
        }
        exit;


        dd(json_encode($request->htdata));
    }

    function updateDataExcel(Request $request)
    {

      
        $id = $request->excel_id;
        $note_obj =  CustomerNote::find($id);
     
        $note_obj->type = 'excel';
        $note_obj->json_data = $request->htdata;
      
        if ($note_obj->save()) {
            $arr['success'] = 'yes';
            return json_encode($arr);
        }
        exit;


        dd(json_encode($request->htdata));
    }

   

    function getExcelData($id)
    {

        $excel_data = CustomerNote::find($id);
        $excel_data_arr['data'] = json_decode($excel_data->json_data);

        return(json_encode($excel_data_arr));
    }
}
