<?php
namespace App\Modules\Crm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Controller;
use App\Modules\Crm\Http\CustomerServiceType;


use Auth;

class ServiceItemsController extends Controller
{

    public function index()
    {
        //$controller = $this->controller;
        $service_items = CustomerServiceType::all();
        $route_delete = 'admin.service_item.destroy';

        if (\Request::ajax()) {
            return view('crm::service_item.ajax_index', compact('service_items'))->render();
        }
        return view('crm::service_item.index', compact('service_items', 'route_delete'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('crm::service_item.add');
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
                'title' => 'required|unique:customer_service_types|max:15',
                'description' => 'required|max:15',
                
             ]
         );
        
        $service_item = new CustomerServiceType();
        $service_item->title = $request->title;
        $service_item->description = $request->description;
        $service_item->save();


        $arr['success'] = 'Service item added successfully';
     
        return $arr;
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       //$id = $request->id;
        $service_item = CustomerServiceType::findorFail($id);
        $service_item->delete();
       

        $arr['success'] = 'Service item deleted successfully';
        return $arr;
    }
}
