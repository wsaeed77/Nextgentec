<?php
namespace App\Modules\Backupmanager\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\Backupmanager\Http\Script;

class ProvisioningController extends Controller
{

	public function index() {
		$scripts = Script::paginate(15);
		//dd($scripts);
		return view('backupmanager::index',compact('scripts'));
	}

	public function editor(Request $request)
	{
		$script = Script::with(['scriptBody'])->where('id', $request->id)->first();
		return view('backupmanager::editor',compact('script'));
	}

	/* Save functionality for ACE editor */
	public function editorSave(Request $request)
	{
		$script = Script::with(['scriptBody'])->find($request->id);
		$script['scriptBody']['script'] = $request->script;

		if($script->push()) {
			$arr['success'] = true;
		} else {
			$arr['success'] = false;
		}
		return json_encode($arr);
	}

	/* Retreive a script for execution */
	public function getScript(Request $request) {

		if (strlen($request->uuid) != 36)
			die();

		$script = Script::with(['scriptBody'])->where('id', $request->id)->first();

		if (strlen($script->uuid) != 36 || $script->uuid != $request->uuid)
			die();

		\Httpauth::secure();
		$config = array('username' => 'admin', 'password' => '1234f');
		\Httpauth::make($config)->secure();
	}

}
