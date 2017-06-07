<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\SignUpPostRequest;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Model\User;
use App\Model\Role;
use Auth;

class UserController extends Controller
{
    //private $admin = 1;
    private $controller = 'user';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       /* $timezone_identifiers = \DateTimeZone::listIdentifiers();
        echo '<pre>';
        print_r($timezone_identifiers);
        exit;*/
        $controller = $this->controller;
        //$users = User::where('role_id','<>',$this->admin)->get();
        $users = User::get();
            
        return view('admin.users.index',compact('users','controller'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $roles = Role::select(['id','display_name'])->get();
        return view('admin.users.add',compact('roles'));
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SignUpPostRequest $request)
    {
        //dd($request->all());

        $user = new User;
        $user->f_name = $request->f_name;
        $user->l_name = $request->l_name;

        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        
        $user->save();

        if($request->role)
        $user->attachRole($request->role);
        //role
        return redirect()->intended('admin/user'); 
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
       //$user = User::where('id',$id)->where('role_id','<>',$this->admin)->first();
        $user = User::find($id);
        $roles = Role::select(['id','display_name'])->get();
        //dd($user->roles);
        if($user->roles)
       {
            foreach( $user->roles as $role )
            {
                $user_role = $role->id;
            }
        }
        return view('admin.users.add',compact('user','roles','user_role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SignUpPostRequest $request, $id)
    {
        //$flight = App\Flight::find(1);
        $user = User::find($id);
       $user->f_name = $request->f_name;
        $user->l_name = $request->l_name;
        $user->email = $request->email;

        if (!empty($request->password))
        {
           $user->password = bcrypt($request->password);
        }
        
        $user->detachRoles($user->roles);
        if($request->role)
        $user->attachRole($request->role);
        $user->save();
        return redirect()->intended('admin/user');
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
        $user = User::findorFail($id);
        $user->detachRoles($user->roles);
        $user->delete();
        //Session::flash('flash_message', 'User successfully deleted!');
        return redirect()->intended('admin/user');
    }
}
