<?php
namespace App\Modules\Assets\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\Crm\Http\Customer;
use App\Modules\Crm\Http\CustomerLocation;
use App\Modules\Assets\Http\Asset;

use App\Modules\Assets\Http\Network;

use App\Modules\Assets\Http\AssetRole;
use Datatables;

use App\Model\Role;
use App\Model\User;
use Auth;
use Mail;
use URL;

use Session;

class NetworkController extends Controller
{

    public function index()
    {
        // Get the Customers
        $customers_obj = Customer::with(['locations'])->get();
        $customers = [];
        if ($customers_obj->count()) {
            foreach ($customers_obj as $customer) {
                $customers[$customer->id]=$customer->name.'('.$customer->email_domain.')';
                //dd($customer);
            }
        }
        //dd($customer);

        return view('assets::network.network_list', [ 'customers' => compact('customers'), 'locations' => '' ]);
        //return "Controller Index";
    }
    /*
	networs_list_bycustomer
	*/
    function networkIndex($id = null)
    {

        $global_date = $this->global_date;
        if (!empty(Session::get('cust_id'))) {
            $networks = Network::with(['location'])
            ->join('customer_locations', 'networks.customer_location_id', '=', 'customer_locations.id')
            ->select('networks.*', 'customer_locations.customer_id')
            ->where('customer_id', Session::get('cust_id'));
        } else {
            $networks = Network::with(['location']);
        }
//dd($networks->get());
        return Datatables::of($networks)
        ->addColumn('action', function ($network) {
            $return = '<div class="btn-group"><button type="button" class="btn btn-xs edit "
			data-toggle="modal" data-id="'.$network->id.'" id="modaal" data-target="#modal-edit-network">
			<i class="fa fa-edit"></i>
			</button>
			<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-id="'.$network->id.'" id="modaal" data-target="#modal_network_delete"><i class="fa fa-times-circle"></i></button></div>';

            return $return;
        })
        ->addColumn('customer', function ($network) {
            if ($network->location) {
                return '<button class="btn bg-gray-active  btn-sm" type="button">
				<i class="fa fa-user"></i>
				<span>'.$network->location->customer->name.'</span>
				</button>';
            } else {
                return '<button class="btn bg-gray-active  btn-sm" type="button">
				<i class="fa fa-user"></i>
				<span></span>
				</button>';
            }
        })
        ->editColumn('created_at', function ($network) use ($global_date) {
            return  date($global_date, strtotime($network->created_at));
        })
        ->setRowId('id')

        ->make(true);
    }



    function store(Request $request)
    {
        //dd($request->all());

        $this->validate(
            $request,
            [
            'customer' => 'required',
            'name' => 'required',
            ]
        );

        $network = new Network();
        //$network->customer_id = $request->customer;
        $network->customer_location_id = $request->location_index;
        $network->name = $request->name;
        $network->lansubnet = $request->lansubnet;
        $network->langw = $request->langw;
        $network->lansubnetmask = $request->lansubnetmask;
        $network->wanip = $request->wanip;
        $network->wangw = $request->wangw;
        $network->wansubnetmask = $request->wansubnetmask;
        $network->dns1 = $request->dns1;
        $network->dns2 = $request->dns2;
        $network->notes = $request->notes;

        $network->save();

        $arr['success'] = 'Network added successfully';
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
        $network = Network::with(['location','location.customer'])
        ->leftJoin('customer_locations', 'networks.customer_location_id', '=', 'customer_locations.id')
        ->select('networks.*', 'customer_locations.customer_id')
        ->where('networks.id', $id)
        ->first();
        //$network = Network::with(['location','location.customer']);
        //dd($network);
        $arr['html_content'] =  view('assets::network.show_partial', compact('network'))->render();
        $arr['network_name'] = $network->name;
        return json_encode($arr);
        exit;
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        //dd($id);
        $network = Network::with(['location','location.customer'])
        ->leftJoin('customer_locations', 'networks.customer_location_id', '=', 'customer_locations.id')
        ->select('networks.*', 'customer_locations.customer_id')
        ->where('networks.id', $id)->first();

        //dd($network);
        //	$arr['locations'] = $locations;

        $arr['network'] = $network;

        //$arr['asset_name'] = $asset->name;
        return json_encode($arr);
        exit;
        //
    }

    function update(Request $request)
    {
        //dd($request->all());

        $this->validate(
            $request,
            [
            'customer' => 'required',
            'name' => 'required',
            ]
        );

        $network =  Network::find($request->id);
        //$network->customer_id = $request->customer;
        $network->name = $request->name;
        $network->customer_location_id = $request->location_index;
        $network->lansubnet = $request->lansubnet;
        $network->langw = $request->langw;
        $network->lansubnetmask = $request->lansubnetmask;
        $network->wanip = $request->wanip;
        $network->wangw = $request->wangw;
        $network->wansubnetmask = $request->wansubnetmask;
        $network->dns1 = $request->dns1;
        $network->dns2 = $request->dns2;
        $network->notes = $request->notes;

        $network->save();


        $arr['success'] = 'Network updated successfully';
        return json_encode($arr);
        exit;
    }

    public function deleteNetwork(Request $request)
    {
             $network =  Network::find($request->id);
             $network->delete();
             $arr['success'] = 'Network deleted sussessfully';
                    return json_encode($arr);
                    exit;
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        //
    }
}
