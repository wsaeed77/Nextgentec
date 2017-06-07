<?php
namespace App\Modules\Crm\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Modules\Crm\Http\TicketStatus;
use App\Modules\Crm\Http\Ticket;

class TicketsStatus extends Controller
{

    public function index()
    {
        $statuses = TicketStatus::all();
        //dd($statuses);
        if (\Request::ajax()) {
            return view('crm::ticketstatus.ajax_index', compact('statuses'))->render();
        }
        return view('crm::settings.ticketstatus.index', compact('statuses'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('crm::ticketstatus.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate(
            $request,
            [

                'title'=>'required',



            ]
        );
        $status = new TicketStatus;
        $status->title = $request->title;
        $status->color_code = $request->color_code;
        $status->save();

        $arr['success'] = 'Status added successfully';
        return json_encode($arr);
            exit;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $status = TicketStatus::find($id);
        //return view('crm::ticketstatus.add',compact('status'));

         $arr['status'] =  $status ;
         //$arr['success'] = 'Status updated successfully';
        return json_encode($arr);
            exit;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->status_id;
        //dd($request->all());
        $status = TicketStatus::find($id);
        $this->validate(
            $request,
            [

                'title'=>'required',
            ]
        );

        $status->title = $request->title;
        $status->color_code = $request->color_code;
        $status->save();
        $arr['success'] = 'Status updated successfully';
        return json_encode($arr);
            exit;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ajaxDelete(Request $request)
    {
        $status = TicketStatus::find($request->id);
        //dd($status);
        //$status->tickets()->sync($id);
        foreach ($status->tickets as $ticket) {
            $ticket = Ticket::find($ticket->id);
            $ticket->ticket_status_id = null;
            $ticket->save();
            # code...
        }
        $status->delete();

        $arr['success'] = 'Status deleted successfully';
        return json_encode($arr);
            exit;
    }
}
