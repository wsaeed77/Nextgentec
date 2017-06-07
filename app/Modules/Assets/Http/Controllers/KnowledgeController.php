<?php
namespace App\Modules\Assets\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\Crm\Http\Customer;
use App\Modules\Crm\Http\CustomerLocation;
use App\Modules\Assets\Http\Asset;

use App\Modules\Assets\Http\KnowledgePassword;
use App\Modules\Assets\Http\KnowledgeProcedure;
use App\Modules\Assets\Http\KnowledgeSerialNumber;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

use App\Modules\Assets\Http\Tag;

use Datatables;

use App\Model\Role;
use App\Model\User;
use Auth;
use Mail;
use URL;
use Session;

class KnowledgeController extends Controller
{

	public function index()
	{

		$customers_obj = Customer::with(['locations','locations.contacts'])->where('is_active',1)->get();
		$customers = [];
		 if($customers_obj->count())
		{
				foreach($customers_obj as $customer) {
						$customers[$customer->id]=$customer->name.'('.$customer->email_domain.')';
						//dd($user->id);
				}

		}


        return view('assets::knowledge.index',compact('customers'));
		//return "Controller Index";
	}


    function passwordsList()
    {
        $customers_obj = Customer::with(['locations','locations.contacts'])->get();
        $customers = [];
         if($customers_obj->count())
        {
                foreach($customers_obj as $customer) {
                        $customers[$customer->id]=$customer->name.'('.$customer->email_domain.')';
                        //dd($user->id);
                }

        }

        $tag_records = Tag::all();
        $tags =[];
        foreach($tag_records as $tag) {
                        $tags[$tag->id]=$tag->title;
                        //dd($user->id);
                }

          return view('assets::knowledge.passwords_list',compact('customers','tags'));

    }
	function passwordsIndex($id=Null)
	{
		$global_date = $this->global_date;

        if(!empty(Session::get('cust_id')))
        {
            $passwords = KnowledgePassword::with(['customer','tags','asset','vendor'])->where('knowledge_passwords.customer_id',Session::get('cust_id'))->select('knowledge_passwords.*');
        }
        else
		  $passwords = KnowledgePassword::with(['customer','tags','asset'])->selectRaw('distinct knowledge_passwords.*');

        //dd($passwords);
		return Datatables::of($passwords)


				->addColumn('action', function ($password) {
						$return = '<div class="btn-group">';

						$return .= '<button type="button" class="btn btn-xs edit "
											data-toggle="modal" data-id="'.$password->id.'" id="modaal" data-target="#modal-edit-knowledge-pass">
											<i class="fa fa-edit " ></i></button>';

						$return .=' <button type="button" class="btn btn-danger btn-xs"
												data-toggle="modal" data-id="'.$password->id.'" id="modaal" data-target="#modal_password_delete">
											<i class="fa fa-times-circle"></i></button></div>';

						$return .= '</div>';

						return $return;
				})


				->addColumn('customer',function ($password){
                    if($password->customer)
                    {
				        return '<button class="btn bg-gray-active  btn-sm" type="button">
                            <i class="fa fa-user"></i>
                                <span>'.$password->customer->name.'</span>
                            </button> ';
                    }
                    else
                    {
                        return '<button class="btn bg-gray-active  btn-sm" type="button">
                            <i class="fa fa-user"></i>
                                <span></span>
                            </button>';
                    }
				})

                ->addColumn('hashtags',function ($password){
                    $return  = '';
                    if($password->tags)
                    {
                        foreach ($password->tags as $tag) 
                        {
                           
                                 $return .='<button class="btn bg-gray-active  btn-sm" type="button">
                            # <span>'.$tag->title.'</span>
                            </button> ';
                           
                        }

                    }
                    return $return;

                })

                ->addColumn('device',function ($password){
                    $return  = '';
                    if($password->asset)
                    {

                            $return .='<a class="btn btn-primary  btn-sm" type="button"  data-toggle="modal" data-id="'.$password->asset->id.'" id="modaal" data-target="#modal-show-asset">
                            <i class="fa fa-eye"></i>&nbsp; <span>'.$password->asset->name.'</span>
                            </a> ';


                    }
                    if($password->vendor)
                    {

                            $return .='<a class="btn btn-primary  btn-sm" type="button"  data-toggle="modal" data-vendor-id="'.$password->vendor_id.'" id="modaal" data-target="#modal-vendor-detatil">
                            <i class="fa fa-eye"></i>&nbsp; <span>'.$password->vendor->name.'</span>
                            </a> ';


                    }
                    return $return;

                })
				->editColumn('created_at', function ($password) use ($global_date){

						return  date($global_date,strtotime($password->created_at));
				})

				->setRowId('id')

				  ->make(true);
	}

		function proceduresList()
    {
        $customers_obj = Customer::with(['locations','locations.contacts'])->get();
        $customers = [];
         if($customers_obj->count())
        {
                foreach($customers_obj as $customer) {
                        $customers[$customer->id]=$customer->name.'('.$customer->email_domain.')';
                        //dd($user->id);
                }

        }
          return view('assets::knowledge.procedures_list',compact('customers'));

    }

	/**
	 * [proceduresIndex description]
	 * @param  int $id	ID of the customer, if ID is 0 show unassigned procedures
	 */
	function proceduresIndex($id=NULL) {
	$global_date = $this->global_date;
		if(!empty($id) || $id == 0) {
		 	$procedures = KnowledgeProcedure::with(['customer'])->where('customer_id',$id);
		} else {
			$procedures = KnowledgeProcedure::with(['customer']);
		}

		return Datatables::of($procedures)
			->addColumn('action', function ($procedure) {
				$return = '<div class="btn-group"><button type="button" class="btn btn-xs edit "
				data-toggle="modal" data-id="'.$procedure->id.'" id="modaal" data-target="#modal-edit-knowledge-procedure">
				<i class="fa fa-edit"></i>
				</button>
				<a class="btn btn-xs btn-default" href="'.URL::route('admin.knowledge.procedure.detail',$procedure->id).'" target="_blank" ><i class="fa fa-eye"></i></a>
				<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-id="'.$procedure->id.'" id="modaal" data-target="#modal_procedure_delete"><i class="fa fa-times-circle"></i></button></div>';

				return $return;
			})
			->editColumn('created_at', function ($procedure) use ($global_date){
				return date($global_date,strtotime($procedure->created_at));
			})
			->addColumn('customer',function ($procedure){
      	if($procedure->customer) {
			  	return '<button class="btn bg-gray-active  btn-sm" type="button">
          <i class="fa fa-user"></i><span>'.$procedure->customer->name.'</span>
          </button>';
        } else {
					return '<button class="btn bg-gray-active  btn-sm" type="button">
          <i class="fa fa-user"></i><span></span></button>';
        }
			})->make(true);
	}

function serialnumberList()
    {
        $customers_obj = Customer::with(['locations','locations.contacts'])->get();
        $customers = [];
         if($customers_obj->count())
        {
                foreach($customers_obj as $customer) {
                        $customers[$customer->id]=$customer->name.'('.$customer->email_domain.')';
                        //dd($user->id);
                }

        }
          return view('assets::knowledge.serial_numbers_list',compact('customers'));

    }

	function serialnumberIndex($id=Null)
	{
		$global_date = $this->global_date;

        if(!empty(Session::get('cust_id')))
           $serial_numbers = KnowledgeSerialNumber::with(['customer'])->where('customer_id',Session::get('cust_id'));
        else
		$serial_numbers = KnowledgeSerialNumber::with(['customer']);


		return Datatables::of($serial_numbers)


				->addColumn('action', function ($serial_number) {

				$return = '<button type="button" class="btn btn-primary btn-sm"	 data-toggle="modal" data-id="'.$serial_number->id.'" id="modaal" data-target="#modal-edit-serial-number">
							 <i class="fa fa-pencil"></i> Edit
					 </button>

				<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-id="'.$serial_number->id.'" id="modaal" data-target="#modal-show-knowledge" data-type="serial_number">
							 <i class="fa fa-eye"></i> View
					 </button>
				<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-id="'.$serial_number->id.'" id="modaal" data-target="#modal_serial_delete">
						<i class="fa fa-times-circle"></i> Delete
				</button>';

						return $return;
				})
				->editColumn('created_at', function ($serial_number) use ($global_date){

						return  date($global_date,strtotime($serial_number->created_at));
				})
				->addColumn('customer',function ($serial_number){

                     if($serial_number->customer)
                     {
				            return '<button class="btn bg-gray-active  btn-sm" type="button">
                            <i class="fa fa-user"></i>
                                <span>'.$serial_number->customer->name.'</span>
                            </button>';
                    }
                    else
                    {
                        return '<button class="btn bg-gray-active  btn-sm" type="button">
                            <i class="fa fa-user"></i>
                                <span></span>
                            </button>';
                    }
				})
					->make(true);
	}



    public function storePassword(Request $request)
    {
			//dd($request->all());
			$this->validate($request,
				 [
				   // 'system' => 'required',
                    'login' => 'required',
					'password' => 'required',


				 ]);
                    $password = new KnowledgePassword();

                    if($request->customer)
                    $password->customer_id = $request->customer;
				    $password->login = $request->login;
                    $password->password = $request->password;
					$password->notes = $request->notes;

                    $password->save();
                    $password->tags()->sync($request->tags);
                    $arr['success'] = 'Password added sussessfully';
            return json_encode($arr);
            exit;



    }

    function storePasswordTag(Request $request)
    {
        $this->validate($request,
                 [
                    'tag' => 'required',
                 ]);

        $tag = new Tag();
        $tag->title = $request->tag;
        $tag->save();

        $arr['success'] = 'Tag added sussessfully';
        return json_encode($arr);
        exit;
    }

    function getTags()
    {
        $tag_records = Tag::all();
        foreach($tag_records as $tag) {
                        $tags[]=['id'=>$tag->id,
                                 'text'=>$tag->title];
                        //dd($user->id);
                }


        return json_encode($tags);
        exit;
    }

	public function editPassword($id)
    {
  		$password = KnowledgePassword::with(['customer','tags'])->where('id',$id)->first();
        $arr['password'] = $password;
        return json_encode($arr);
        exit;
    }


     public function updatePassword(Request $request)
    {
            //dd($request->all());
        $id = $request->id;
            $this->validate($request,
                 [

                    'login' => 'required',
                    'password' => 'required',

                 ]);

            $password = KnowledgePassword::find($id);
            //$password->system = $request->system;
            if($request->customer)
            $password->customer_id = $request->customer;
            $password->login = $request->login;
            $password->password = $request->password;
            $password->notes = $request->notes;

             $password->save();
             if($request->tags)
            $password->tags()->sync($request->tags);
            $arr['success'] = 'Password added sussessfully';
            return json_encode($arr);
            exit;



    }


		public function storeProcedure(Request $request) {
    	//dd($request->all());
      $this->validate($request,
           [
              'title' => 'required',
           ]);
	    $procedure = new KnowledgeProcedure();
	    $procedure->title = $request->title;
	    if($request->customer)
	    $procedure->customer_id = $request->customer;
	    $procedure->procedure = $request->procedure;
			$procedure->image_dir = session('imageId');
	    $procedure->save();
	    $arr['success'] = 'Procedure added sussessfully';

			// Make the image directory
			$img_dir = storage_path('image_upload/knowledge/'.$procedure->image_dir);
			if(!File::exists($img_dir))
				File::makeDirectory($img_dir);

			// Destroy the session variable for the image storage directory
			session()->forget('imageId');

      return json_encode($arr);
      exit;

		}

    public function editProcedure($id)
    {
        $procedure = KnowledgeProcedure::with(['customer'])->where('id',$id)->first();
        $arr['procedure'] = $procedure;
        return json_encode($arr);
        exit;
    }

    public function updateProcedure(Request $request)
    {
        $id = $request->id;
            //dd($request->all());
	    $this->validate($request,
		    	[
	            'title' => 'required',
      		]);
	    $procedure = KnowledgeProcedure::find($id);
	    $procedure->title = $request->title;
	    $procedure->customer_id = $request->customer;
	    $procedure->procedure = $request->procedure;
			$procedure->image_dir = $request->image_dir;
	    $procedure->save();
	    $arr['success'] = 'Procedure updated sussessfully';

			// Destroy the session variable for the image storage directory
			session()->forget('imageId');

      return json_encode($arr);
      exit;
    }

  	public function storeSerialNumber(Request $request)
    {
        //dd($request->all());
        $this->validate($request,
             [
                'title' => 'required',
                'serial_number' => 'required'
            ]);
                $password = new KnowledgeSerialNumber();
                $password->title = $request->title;
                if($request->customer)
                $password->customer_id = $request->customer;
                $password->serial_number = $request->serial_number;

                $password->notes = $request->notes;

                $password->save();
                $arr['success'] = 'Serial number added sussessfully';
        return json_encode($arr);
        exit;
    }
    public function editSerialNumber($id)
    {
        $serial_number = KnowledgeSerialNumber::with(['customer'])->where('id',$id)->first();
        $arr['serial_number'] = $serial_number;
        return json_encode($arr);
        exit;



    }

    public function updateSerialNumber(Request $request)
    {
        $id = $request->id;
            //dd($request->all());
            $this->validate($request,
                 [
                    'title' => 'required',
                    'serial_number' => 'required'
                ]);
                    $password = KnowledgeSerialNumber::find($id);
                    $password->title = $request->title;
                    if($request->customer)
                    $password->customer_id = $request->customer;
                    $password->serial_number = $request->serial_number;

                    $password->notes = $request->notes;

                    $password->save();
                    $arr['success'] = 'Serial number updated sussessfully';
            return json_encode($arr);
            exit;



    }

    function procedureDetail($id)
    {
			$procedure = KnowledgeProcedure::with(['customer'])->where('id',$id)->first();

      return  view('assets::knowledge.show_procedure',compact('procedure'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($type,$id)
    {
        if($type=='procedure')
        {
            $procedure = KnowledgeProcedure::with(['customer'])->where('id',$id)->first();
            $type = 'procedure';
            $arr['html_content'] =  view('assets::knowledge.show_partial',compact('procedure','type'))->render();
            //$arr['content'] = $procedure;
            $arr['type'] =  $type;

        }

        if($type=='serial_number')
        {
            $serial_number = KnowledgeSerialNumber::with(['customer'])->where('id',$id)->first();
            $type = 'serial_number';
            $arr['html_content'] =  view('assets::knowledge.show_partial',compact('serial_number','type'))->render();
            //$arr['content'] = $serial_number;
            $arr['type'] = $type;

        }
				 return json_encode($arr);
			exit;

        //
    }

		public function ajaxDetails($id) {
			$cusid = Session::get('cust_id');

      $password = KnowledgePassword::with(['customer','tags'])
				->where('id',$id)->first();

			return view('assets::knowledge.detail_partial',compact('password'));
		}


    public function deletePassword(Request $request)
    {
    	$password = KnowledgePassword::find($request->id);
        if($password->vendor_id !='')
             $arr['error'] = "Password can not be deleted, it is associated with Vendor ID # $password->vendor_id.";
         elseif($password->asset_id !='')
             $arr['error'] = "Password can not be deleted, it is associated with Asset ID # $password->asset_id.";
         else
         {
            $password->delete();
            $arr['success'] = 'Password deleted sussessfully';
         }
      	return json_encode($arr);
        exit;
    }


    public function deleteProcedure(Request $request)
    {
      $procedure = KnowledgeProcedure::find($request->id);
			$path = storage_path('image_upload/knowledge/'.$procedure->image_dir);

			if (!empty($procedure->image_dir)) {
				if (File::deleteDirectory($path)) {
					$procedure->delete();
					$arr['success'] = 'Procedure deleted sussessfully';
		    	return json_encode($arr);
				}
			}

			return '{"success":"There was an error deleting the procedure."}';
      exit;

    }

     public function deleteSerialNumber(Request $request)
    {
        //
         $serial_number = KnowledgeSerialNumber::find($request->id);
         $serial_number->delete();
         $arr['success'] = 'Serial number deleted sussessfully';
            return json_encode($arr);
            exit;

    }

		private function generateGuid() {
	    $s = strtoupper(md5(uniqid(rand(),true)));
	    $guidText =
	        substr($s,0,8) . '-' .
	        substr($s,8,4) . '-' .
	        substr($s,12,4). '-' .
	        substr($s,16,4). '-' .
	        substr($s,20);
    	return $guidText;
		}

		/**
		 * Returns a unique ID used for generating an image storage directory
		 * specific to a procedure. This way when the procedure is deleted we
		 * can delete all the associated images.
		 *
		 * @return [type] [description]
		 */
		public function getImageDirUniqid() {
			$id = uniqid();

			if (empty(session('imageId'))) {
				session(['imageId' => $id]);
				return json_encode(array('imageId' => $id));
			} else {
				return json_encode(array('imageId' => session('imageId')));
			}
		}

		public function storeImage(Request $request)
    {
			$allowed = array('png', 'jpg', 'gif');
			$rules = [
					'file' => 'required|image|mimes:jpeg,jpg,png,gif'
			];

			if (!empty($request->image_dir)) {
				if($request->hasFile('file') ) {
					$image_dir = $request->image_dir;
	      	$file = $request->file('file');

	        if(!in_array($file->guessExtension(), $allowed) &&
					session('imageId') != $image_dir){
	            return '{"error":"Invalid File type"}';
	        } else {
						$guid = $this->generateGuid();
						$fileName = $guid .'.'. $file->guessExtension();
						$path = storage_path('image_upload/knowledge/'.$image_dir);

						// Make image folder if it does not exist
						if(Storage::MakeDirectory($path, 0775, true)) {
							if ($file->move($path, $fileName)) {
								$url = parse_url(URL::route('admin.knowledge.get.image', ['filename' => $fileName, 'folder' => $image_dir ]), PHP_URL_PATH);
								//$url = url($purl);
								return json_encode(array(
									'url' => $url,
									'dir' => $image_dir,
									'id' => $fileName
								), JSON_UNESCAPED_SLASHES);
		            exit;
		          }
						} else {
								return '{"error":"There was an error saving the file"}';
						}
	        }
				} else {
						return '{"error":"Invalid File type"}';
				}
			} else {
					return '{"error":"Unable to upload file"}';
				}
		}

		public function retrieveImage($folder, $filename) {
			$path = storage_path('image_upload/knowledge/'.$folder.'/'.$filename);
			return Image::make($path)->response();
		}

		public function deleteImage($folder, $filename) {
			$path = storage_path('image_upload/knowledge/'.$folder.'/'.$filename);

			if (File::delete($path)) {
				return '{"status":"success"}';
			}
			return '{"status":"error"}';
		}

}
