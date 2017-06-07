<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Permission;
use Datatables;
use URL;

class PermissionsController extends Controller
{
    private $controller = 'permissions';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $controller = $this->controller;
      //$permissions = Permission::select(['id','name','display_name','description','created_at'])->paginate(10);;

        if (\Request::ajax()) {
            return view('admin.permissions.ajax_index', compact('controller'))->render();
        }
           return view('admin.permissions.index', compact('controller'));
    }

    public function ajaxDataIndex()
    {
        $global_date = $this->global_date;
        //$controller = $this->controller;
        $permissions =Permission::select(['id','name','display_name','description','created_at']);
       

        return Datatables::of($permissions)


            ->addColumn('action', function ($permission) {

                $return = '<div class="btn-group"> <button type="button" class="btn  btn-xs"
                                  data-toggle="modal" data-id="'.$permission->id.'" id="modaal" data-target="#modal-edit-permission">
                                    <i class="fa fa-edit"></i>
                                </button>
                             
                             <button type="button" class="btn btn-danger btn-xs"
                                  data-toggle="modal" data-id="'.$permission->id.'" id="modaal" data-target="#modal-delete-permission-ajax">
                                    <i class="fa fa-times-circle"></i>
                                </button></div>';
                               
                              
                            
                return $return;
            })
            ->editColumn('created_at', function ($permission) use ($global_date) {
                return date($global_date, strtotime($permission->created_at));
            })
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.permissions.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
                'name' => 'required|unique:permissions|max:50',
                'display_name' => 'required',
                'description' => 'required',
            ]);


        $permission = new Permission();

        $permission->name         = $request->name;
        $permission->display_name = $request->display_name; // optional
        $permission->description  = $request->description; // optional
        $permission->save();

        //print_r($request->all()); die('asdas');
        return redirect()->route('admin.setting.permissions');
         //$arr['success'] = 'Permission created successfully';
        //return json_encode($arr);
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
        $permission = Permission::where('id', $id)->where('id', $id)->first();
      //dd($permission);
       //echo $user->name;
       //exit;
       //return view('admin.permissions.add',compact('permission'));
        $arr['permission'] = $permission;
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
        $id = $request->permission_id_edit;
        
         $this->validate($request, [
                'name' => 'required|max:50|unique:permissions,name,'.$id,
                'display_name' => 'required',
                'description' => 'required',
            ]);

        $permission = Permission::find($id);
        $permission->name         = $request->name;
        $permission->display_name = $request->display_name; // optional
        $permission->description  = $request->description; // optional
        $permission->save();
        //return redirect()->route('admin.permissions.index');

         $arr['success'] = 'Permission updated successfully';
        return json_encode($arr);
            exit;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      //dd($id);
        //dd($request->id);
        $id = $request->id;
        $permission = Permission::findorFail($id);
        $permission->delete();
        //Session::flash('flash_message', 'User successfully deleted!');
        return redirect()->intended('admin/permissions');
    }


    public function ajaxDelete($id)
    {
      //dd($id);
        //dd($request->id);
       //$id = $request->id;
        
        $permission = Permission::findorFail($id);
        $permission->delete();
        //Session::flash('flash_message', 'User successfully deleted!');
        //return redirect()->intended('admin/permissions');
        $arr['success'] = 'Permission deleted successfully';
        return json_encode($arr);
          exit;
    }
}
