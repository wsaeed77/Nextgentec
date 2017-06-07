<?php
namespace App\Modules\Assets\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\Crm\Http\Customer;
use App\Modules\Crm\Http\CustomerLocation;
use App\Modules\Assets\Http\Asset;

use App\Modules\Assets\Http\AssetRole;
use App\Modules\Assets\Http\KnowledgePassword;
use App\Modules\Assets\Http\AssetVirtualType;
use App\Modules\Assets\Http\Tag;
use Datatables;

use App\Model\Role;
use App\Model\User;
use Auth;
use Mail;
use URL;
use Session;

class AssetsController extends Controller
{

    public function index()
    {

        //return view('assets::index');
        //return "Controller Index";
        return view('assets::assets');
    }

    function assetsAll()
    {
        $global_date = $this->global_date;
        if (!empty(Session::get('cust_id'))) {
            $assets = Asset::with(['customer'])->where('customer_id', Session::get('cust_id'));
        } else {
            $assets = Asset::with(['customer']);
        }

            //dd($assets);
        return Datatables::of($assets)


        ->addColumn('action', function ($asset) {


            $return = '<div class="btn-group">';

            $return .= '<button type="button" class="btn btn-xs edit "
			data-toggle="modal" data-id="'.$asset->id.'" id="modaal" data-target="#modal-edit-asset">
			<i class="fa fa-edit " ></i></button>';

            $return .=' <button type="button" class="btn btn-danger btn-xs"
			data-toggle="modal" data-id="'.$asset->id.'" id="modaal" data-target="#modal_assest_delete" data-type="network">
			<i class="fa fa-times-circle"></i></button></div>';

            $return .= '</div>';





            return $return;
        })
        ->addColumn('customer', function ($asset) {
            if ($asset->customer) {
                return '<button class="btn bg-gray-active  btn-sm" type="button">
			<i class="fa fa-user"></i>
			<span>'.$asset->customer->name.'</span>
		</button>';
            } else {
                return '<button class="btn bg-gray-active  btn-sm" type="button">
		<i class="fa fa-user"></i>
		<span></span>
	</button>';
            }
        })
        ->editColumn('created_at', function ($ticket) use ($global_date) {

            return  date($global_date, strtotime($ticket->created_at));
        })
        ->setRowId('id')
        ->make(true);
    }
    function networkIndex($id = null)
    {
        $global_date = $this->global_date;
        if (!empty(Session::get('cust_id'))) {
            $assets = Asset::with(['customer'])->where('asset_type', 'network')->where('customer_id', Session::get('cust_id'));
        } else {
            $assets = Asset::with(['customer'])->where('asset_type', 'network');
        }

            //dd($assets);
        return Datatables::of($assets)


        ->addColumn('action', function ($asset) {


            $return = '<div class="btn-group">';

            $return .= '<button type="button" class="btn btn-xs edit "
			data-toggle="modal" data-id="'.$asset->id.'" id="modaal" data-target="#modal-edit-asset">
			<i class="fa fa-edit " ></i></button>';

            $return .=' <button type="button" class="btn btn-danger btn-xs"
			data-toggle="modal" data-id="'.$asset->id.'" id="modaal" data-target="#modal_assest_delete" data-type="network">
			<i class="fa fa-times-circle"></i></button></div>';

            $return .= '</div>';





            return $return;
        })
        ->addColumn('customer', function ($asset) {
            if ($asset->customer) {
                return '<button class="btn bg-gray-active  btn-sm" type="button">
			<i class="fa fa-user"></i>
			<span>'.$asset->customer->name.'</span>
		</button>';
            } else {
                return '<button class="btn bg-gray-active  btn-sm" type="button">
		<i class="fa fa-user"></i>
		<span></span>
	</button>';
            }
        })
        ->editColumn('created_at', function ($ticket) use ($global_date) {

            return  date($global_date, strtotime($ticket->created_at));
        })
        ->setRowId('id')
        ->make(true);
    }


    function gatewayIndex($id = null)
    {
        $global_date = $this->global_date;
        if (!empty(Session::get('cust_id'))) {
            $assets = Asset::with(['customer'])->where('asset_type', 'gateway')->where('customer_id', Session::get('cust_id'));
        } else {
            $assets = Asset::with(['customer'])->where('asset_type', 'gateway');
        }


        return Datatables::of($assets)


        ->addColumn('action', function ($asset) {


            $return = '<div class="btn-group">';

            $return .= '<button type="button" class="btn btn-xs edit "
			data-toggle="modal" data-id="'.$asset->id.'" id="modaal" data-target="#modal-edit-asset">
			<i class="fa fa-edit " ></i></button>';

            $return .=' <button type="button" class="btn btn-danger btn-xs"
			data-toggle="modal" data-id="'.$asset->id.'" id="modaal" data-target="#modal_assest_delete" data-type="network">
			<i class="fa fa-times-circle"></i></button></div>';

            $return .= '</div>';



            return $return;
        })
        ->editColumn('created_at', function ($ticket) use ($global_date) {

            return  date($global_date, strtotime($ticket->created_at));
        })
        ->addColumn('customer', function ($asset) {

            return '<button class="btn bg-gray-active  btn-sm" type="button">
			<i class="fa fa-user"></i>
			<span>'.$asset->customer->name.'</span>
		</button>';
        })
        ->setRowId('id')
        ->make(true);
    }


    function pbxIndex($id = null)
    {
        $global_date = $this->global_date;

        if (!empty(Session::get('cust_id'))) {
            $assets = Asset::with(['customer'])->where('asset_type', 'pbx')->where('customer_id', Session::get('cust_id'));
        } else {
            $assets = Asset::with(['customer'])->where('asset_type', 'pbx');
        }


        return Datatables::of($assets)


        ->addColumn('action', function ($asset) {


            $return = '<div class="btn-group">';

            $return .= '<button type="button" class="btn btn-xs edit "
			data-toggle="modal" data-id="'.$asset->id.'" id="modaal" data-target="#modal-edit-asset">
			<i class="fa fa-edit " ></i></button>';

            $return .=' <button type="button" class="btn btn-danger btn-xs"
			data-toggle="modal" data-id="'.$asset->id.'" id="modaal" data-target="#modal_assest_delete" data-type="network">
			<i class="fa fa-times-circle"></i></button></div>';

            $return .= '</div>';




            return $return;
        })
        ->editColumn('created_at', function ($ticket) use ($global_date) {

            return  date($global_date, strtotime($ticket->created_at));
        })
        ->addColumn('customer', function ($asset) {

            return '<button class="btn bg-gray-active  btn-sm" type="button">
			<i class="fa fa-user"></i>
			<span>'.$asset->customer->name.'</span>
		</button>';
        })
        ->setRowId('id')
        ->make(true);
    }

    function serverIndex($id = null)
    {
        $global_date = $this->global_date;
        if (!empty(Session::get('cust_id'))) {
            $assets = Asset::with(['customer','virtual_type'])->where('asset_type', 'server')->where('customer_id', Session::get('cust_id'));
        } else {
            $assets = Asset::with(['customer','virtual_type'])->where('asset_type', 'server');
        }


        return Datatables::of($assets)


        ->addColumn('action', function ($asset) {

            $return = '<div class="btn-group">';

            $return .= '<button type="button" class="btn btn-xs edit "
			data-toggle="modal" data-id="'.$asset->id.'" id="modaal" data-target="#modal-edit-asset">
			<i class="fa fa-edit " ></i></button>';

            $return .=' <button type="button" class="btn btn-danger btn-xs"
			data-toggle="modal" data-id="'.$asset->id.'" id="modaal" data-target="#modal_assest_delete" data-type="network">
			<i class="fa fa-times-circle"></i></button></div>';

            $return .= '</div>';



            return $return;
        })
        ->editColumn('created_at', function ($ticket) use ($global_date) {

            return  date($global_date, strtotime($ticket->created_at));
        })



        ->addColumn('customer', function ($asset) {

            if ($asset->customer) {
                return '<button class="btn bg-gray-active  btn-sm" type="button">
				<i class="fa fa-user"></i>
				<span>'.$asset->customer->name.'</span>
			</button>';
            } else {
                return '<button class="btn bg-gray-active  btn-sm" type="button">
		<i class="fa fa-user"></i>
		<span></span>
	</button>';
            }
        })

        ->setRowId('id')
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers_obj = Customer::with(['locations','locations.contacts'])->where('is_active', 1)->get();
        $asset_roles_obj = AssetRole::all();

        $asset_vtypes_obj = AssetVirtualType::all();


        $customers = [];
        if ($customers_obj->count()) {
            foreach ($customers_obj as $customer) {
                $customers[$customer->id]=$customer->name.'('.$customer->email_domain.')';
                //dd($user->id);
            }
        }

        $asset_roles =[];
        if ($asset_roles_obj->count()) {
            foreach ($asset_roles_obj as $asset_role) {
                $asset_roles[ $asset_role->id]= $asset_role->title;
                //dd($user->id);
            }
        }


        $asset_v_types =[];
        if ($asset_vtypes_obj->count()) {
            foreach ($asset_vtypes_obj as $asset_v_type) {
                $asset_v_types[ $asset_v_type->id]= $asset_v_type->title;
                //dd($user->id);
            }
        }

        return view('assets::add', compact('customers', 'asset_roles', 'asset_v_types'));
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            //dd($request->all());
        $this->validate(
            $request,
            [
            'name' => 'required',
            'customer' => 'required',
            'asset_type' =>'required',

            ]
        );

        if ($request->asset_type == 'network') {
                    // dd($request->asset_type);

            $this->validate(
                $request,
                [
                        //'manufacture' => 'required',
                       // 'model' => 'required',
                ]
            );


            $asset = new Asset();
            $asset->name = $request->name;
            $asset->customer_id = $request->customer;
            $asset->location_id = $request->location;
            $asset->mac_address = $request->mac;
            $asset->manufacture = $request->manufacture;
            $asset->os = $request->os;
            $asset->asset_type = 'network';
            $asset->model = $request->model;
            $asset->ip_address = $request->ip_address;
                    //$asset->user_name = $request->user_name;
                    //$asset->password = $request->password;
            $asset->is_static = $request->is_static;
            $asset->static_type = $request->static_type;
            $asset->notes = $request->notes;
            $asset->save();


            $kpass = new KnowledgePassword();
            $kpass->login = $request->user_name;
            $kpass->password = $request->password;
            $kpass->customer_id = $request->customer;

            $pass = $asset->password()->save($kpass);

            $tag = Tag::firstOrCreate(['title' => 'asset']);
            $pass->tags()->attach([$tag->id]);

            $arr['success'] = 'Asset added sussessfully';
            return json_encode($arr);
            exit;
        }
        if ($request->asset_type == 'gateway') {
                        //dd('here');

            $this->validate(
                $request,
                [
                'manufacture' => 'required',
                'model' => 'required',
                ]
            );


            $asset = new Asset();
            $asset->name = $request->name;
            $asset->customer_id = $request->customer;
            $asset->location_id = $request->location;
            $asset->manufacture = $request->manufacture;
            $asset->asset_type = 'gateway';
            $asset->model = $request->model;
            $asset->lan_ip_address = $request->lan_ip_address;
            $asset->wan_ip_address = $request->wan_ip_address;
                    //$asset->password = $request->password;
                    //$asset->user_name = $request->user_name;



            $asset->notes = $request->notes;
            $asset->save();

            $kpass = new KnowledgePassword();
            $kpass->login = $request->user_name;
            $kpass->password = $request->password;
            $kpass->customer_id = $request->customer;

            $pass = $asset->password()->save($kpass);

            $tag = Tag::firstOrCreate(['title' => 'asset']);
            $pass->tags()->attach([$tag->id]);
            $arr['success'] = 'Asset added sussessfully';

            return json_encode($arr);
            exit;
        }

        if ($request->asset_type == 'pbx') {
                     //dd('here');
            $this->validate(
                $request,
                [
                'manufacture' => 'required',

                ]
            );


            $asset = new Asset();
            $asset->name = $request->name;
            $asset->customer_id = $request->customer;
            $asset->location_id = $request->location;
            $asset->manufacture = $request->manufacture;
            $asset->os = $request->os;
            $asset->asset_type = 'pbx';

            $asset->ip_address = $request->ip_address;
            $asset->host_name = $request->host_name;
                    //$asset->user_name = $request->user_name;
                    //$asset->password = $request->password;
            $asset->admin_gui_address = $request->admin_gui_address;
            $asset->hosted = $request->hosted;

            $asset->save();

            $kpass = new KnowledgePassword();
            $kpass->login = $request->user_name;
            $kpass->password = $request->password;
            $kpass->customer_id = $request->customer;

            $pass = $asset->password()->save($kpass);

            $tag = Tag::firstOrCreate(['title' => 'asset']);
            $pass->tags()->attach([$tag->id]);
            $arr['success'] = 'Asset added sussessfully';
            return json_encode($arr);
            exit;
        }

        if ($request->asset_type == 'server') {
                $asset = new Asset();
                $asset->name = $request->name;
                $asset->customer_id = $request->customer;
                $asset->location_id = $request->location;
                $asset->server_type = $request->server_type;
                $asset->asset_virtual_type_id = $request->virtual_type;
                $asset->asset_type = 'server';
                $asset->roles = json_encode($request->roles);
                $asset->ip_address = $request->ip_address;
                $asset->host_name = $request->host_name;
                    //$asset->serial_number = $request->serial_number;

                

                $asset->notes = $request->notes;
                $asset->save();

                $kpass = new KnowledgePassword();
                $kpass->login = $request->user_name;
                $kpass->password = $request->password;
                $kpass->customer_id = $request->customer;

                $pass = $asset->password()->save($kpass);
                $arr['success'] = 'Asset added sussessfully';
                return json_encode($arr);
                exit;
        }


        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $asset = Asset::with(['customer','location','virtual_type'])->where('id', $id)->first();
                //dd($asset);

        $asset_roles_obj = AssetRole::all();
        $asset_roles =[];
        if ($asset_roles_obj->count()) {
            foreach ($asset_roles_obj as $asset_role) {
                $asset_roles[ $asset_role->id]= $asset_role->title;
                            //dd($user->id);
            }
        }
        $arr['html_content_asset'] =  view('assets::show_partial', compact('asset', 'asset_roles'))->render();
        $arr['asset_name'] = $asset->name;
        return json_encode($arr);
        exit;

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
        $asset = Asset::with(['customer','location','virtual_type','password'])->where('id', $id)->first();
//dd($asset->password);
        $cust_locations = CustomerLocation::where('customer_id', $asset->customer->id)->get();
        $locations = [];
        if ($cust_locations->count()) {
            foreach ($cust_locations as $cust_location) {
                $locations[$cust_location->id]=$cust_location->location_name;
                             //dd($user->id);
            }
        }

        $customers_obj = Customer::with(['locations','locations.contacts'])->get();
        $customers = [];
        if ($customers_obj->count()) {
            foreach ($customers_obj as $customer) {
                $customers[$customer->id]=$customer->name.'('.$customer->email_domain.')';
                            //dd($user->id);
            }
        }


        $asset_roles_obj = AssetRole::all();
        $asset_roles =[];
        if ($asset_roles_obj->count()) {
            foreach ($asset_roles_obj as $asset_role) {
                $asset_roles[ $asset_role->id]= $asset_role->title;
                    //dd($user->id);
            }
        }


        $asset_vtypes_obj = AssetVirtualType::all();
        $asset_v_types =[];
        if ($asset_vtypes_obj->count()) {
            foreach ($asset_vtypes_obj as $asset_v_type) {
                $asset_v_types[ $asset_v_type->id]= $asset_v_type->title;
                        //dd($user->id);
            }
        }
                    //dd($asset);
            //	$arr['locations'] = $locations;
        $arr['html_content_asset'] =  view('assets::edit_partial', compact('asset', 'locations', 'customers', 'asset_roles', 'asset_v_types'))->render();
        $arr['asset_type'] = $asset ->asset_type;

            //$arr['asset_name'] = $asset->name;
        return json_encode($arr);
        exit;
        //
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
        $id = $request->asset_id;
      //dd($request->all());
        $this->validate(
            $request,
            ['name' => 'required',
            'customer' => 'required',
            ]
        );

        if ($request->asset_type == 'network') {
                // dd($request->asset_type);

            $this->validate(
                $request,
                [
                // 'manufacture' => 'required',
                // 'model' => 'required',
                ]
            );

            $asset = Asset::find($id);
            $asset->name = $request->name;
            $asset->customer_id = $request->customer;
            $asset->location_id = $request->location;
            $asset->manufacture = $request->manufacture;
            $asset->os = $request->os;
            $asset->mac_address = $request->mac;
            $asset->asset_type = 'network';
            $asset->model = $request->model;
            $asset->ip_address = $request->ip_address;
                //$asset->user_name = $request->user_name;
                //$asset->password = $request->password;
            $asset->is_static = $request->is_static;
            $asset->static_type = $request->static_type;
            $asset->notes = $request->notes;
            $asset->save();
//dd($asset);
            if ($asset->password) {
                if ($request->user_name =='' && $request->password =='') {
                    $kpass = KnowledgePassword::where('customer_id', $request->customer)->where('asset_id', $id)->delete();
                } else {
                    $kpass['login'] = $request->user_name;
                    $kpass['password'] = $request->password;
                    $asset->password()->update($kpass);
                }
            } else {
                if ($request->user_name !='' && $request->password !='') {
                    $kpass = new KnowledgePassword();
                    $kpass->login = $request->user_name;
                    $kpass->password = $request->password;
                    $kpass->customer_id = $request->customer;

                    $pass = $asset->password()->save($kpass);

                    $tag = Tag::firstOrCreate(['title' => 'asset']);
                    $pass->tags()->attach([$tag->id]);
                }
            }


            $arr['success'] = 'Asset added sussessfully';

            return json_encode($arr);
            exit;
        }

        if ($request->asset_type == 'gateway') {
                //dd('here');
            $this->validate(
                $request,
                [
                'manufacture' => 'required',
                'model' => 'required',
                ]
            );

            $asset = Asset::find($id);
            $asset->name = $request->name;
            $asset->customer_id = $request->customer;
            $asset->location_id = $request->location;
            $asset->manufacture = $request->manufacture;
            $asset->asset_type = 'gateway';
            $asset->model = $request->model;
            $asset->lan_ip_address = $request->lan_ip_address;
            $asset->wan_ip_address = $request->wan_ip_address;
                //$asset->password = $request->password;
                //$asset->user_name = $request->user_name;
            $asset->notes = $request->notes;
            $asset->save();

            if ($asset->password) {
                if ($request->user_name =='' && $request->password =='') {
                    $kpass = KnowledgePassword::where('customer_id', $request->customer)->where('asset_id', $id)->delete();
                } else {
                    $kpass['login'] = $request->user_name;
                    $kpass['password'] = $request->password;
                    $asset->password()->update($kpass);
                }
            } else {
                if ($request->user_name !='' && $request->password !='') {
                    $kpass = new KnowledgePassword();
                    $kpass->login = $request->user_name;
                    $kpass->password = $request->password;
                    $kpass->customer_id = $request->customer;

                    $pass = $asset->password()->save($kpass);

                    $tag = Tag::firstOrCreate(['title' => 'asset']);
                    $pass->tags()->attach([$tag->id]);
                }
            }
            $arr['success'] = 'Asset added sussessfully';
            return json_encode($arr);
            exit;
        }

        if ($request->asset_type == 'pbx') {
                //dd('here');
            $this->validate($request, ['manufacture' => 'required']);

            $asset = Asset::find($id);
            $asset->name = $request->name;
            $asset->customer_id = $request->customer;
            $asset->location_id = $request->location;
            $asset->manufacture = $request->manufacture;
            $asset->os = $request->os;
            $asset->asset_type = 'pbx';

            $asset->ip_address = $request->ip_address;
            $asset->host_name = $request->host_name;
                //$asset->user_name = $request->user_name;
                //$asset->password = $request->password;
            $asset->admin_gui_address = $request->admin_gui_address;
            $asset->hosted = $request->hosted;

            $asset->save();

            if ($asset->password) {
                if ($request->user_name =='' && $request->password =='') {
                    $kpass = KnowledgePassword::where('customer_id', $request->customer)->where('asset_id', $id)->delete();
                } else {
                    $kpass['login'] = $request->user_name;
                    $kpass['password'] = $request->password;
                    $asset->password()->update($kpass);
                }
            } else {
                if ($request->user_name !='' && $request->password !='') {
                    $kpass = new KnowledgePassword();
                    $kpass->login = $request->user_name;
                    $kpass->password = $request->password;
                    $kpass->customer_id = $request->customer;

                    $pass = $asset->password()->save($kpass);

                    $tag = Tag::firstOrCreate(['title' => 'asset']);
                    $pass->tags()->attach([$tag->id]);
                }
            }
            $arr['success'] = 'Asset added sussessfully';
            return json_encode($arr);
            exit;
        }

        if ($request->asset_type == 'server') {
            $asset = Asset::find($id);
            $asset->name = $request->name;
            $asset->customer_id = $request->customer;
            $asset->location_id = $request->location;
            $asset->server_type = $request->server_type;
                //$asset->user_name = $request->user_name;
                //$asset->password = $request->password;
            $asset->admin_gui_address = $request->admin_gui_address;
            $asset->asset_virtual_type_id = $request->virtual_type;
            $asset->asset_type = 'server';
            $asset->roles = json_encode($request->roles);
            $asset->ip_address = $request->ip_address;
            $asset->host_name = $request->host_name;
                // $asset->serial_number = $request->serial_number;

            $asset->notes = $request->notes;
            $asset->save();
            if ($asset->password) {
                $kpass['login'] = $request->user_name;
                $kpass['password'] = $request->password;
                $asset->password()->update($kpass);
            } else {
                $kpass = new KnowledgePassword();
                $kpass->login = $request->user_name;
                $kpass->password = $request->password;
                $kpass->customer_id = $request->customer;

                $pass = $asset->password()->save($kpass);

                $tag = Tag::firstOrCreate(['title' => 'asset']);
                $pass->tags()->save([$tag->id]);
            }
                $arr['success'] = 'Asset added sussessfully';
                return json_encode($arr);
                exit;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function destroy(Request $request)
    {
        $asset =  Asset::find($request->id);
        if ($asset->password) {
            $asset->password()->delete();
        }
        $asset->delete();

        $arr['success'] = 'Asset deleted successfully';
        return json_encode($arr);
        exit;
    }
}
