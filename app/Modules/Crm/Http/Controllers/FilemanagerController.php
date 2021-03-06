<?php
namespace App\Modules\Crm\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//use GuillermoMartinez\Filemanager\Filemanager;
use App\Services\FilemanagerService;
use Storage;
use File;
use URL;
use Image;
use Auth;
use Session;
use Response;
use App\Modules\Crm\Http\Customer;

class FilemanagerController extends Controller
{
    public $path ;
    public $folder;

    public function __construct()
    {

        $this->setPath();
    }
    public function getIndex()
    {

        if (!empty(Session::get('cust_id'))) {
            $customer = Customer::find(Session::get('cust_id'));
        }
        $folder = $this->folder;
        return view('crm::crm.file_manager', compact('customer', 'folder'));
    }


    public function setPath()
    {
        if (!empty(Session::get('cust_id'))) {
            $customer = Customer::find(Session::get('cust_id'));

            if ($customer->folder!='') {
                $this->path = storage_path('customer_files/'.$customer->folder);
                $this->folder = $customer->folder;
            } else {
                $uuid = $this->generateGuid();
                $this->path = storage_path('customer_files/'.$uuid);
                $this->folder = $uuid;


                 File::MakeDirectory($this->path, 0775, true);

                 $customer->folder = $uuid;
                 $customer->save();
            }
        }
    }
    public function getConnection()
    {
        if (!empty(Session::get('cust_id'))) {
            $extra = [
                          "source" => $this->path,//$path,
                          "url" => url('/'),
                          "doc_root"=>'',
                          'c_folder' => $this->folder,
                          "ext" => ["jpg","jpeg","gif","png","svg","txt","pdf","odp","ods","odt","rtf","doc","docx","xls","xlsx","ppt","pptx","csv","ogv","mp4","webm","m4v","ogg","mp3","wav","zip","rar"],
                                "upload" => [
                                    "number" => 5,
                                    "overwrite" => false,
                                    "size_max" => 10
                                    ],
                                "images" => [
                                    "images_ext" => ["jpg","jpeg","gif","png"],
                                    "resize" => ["thumbWidth" => 120,"thumbHeight" => 90]
                                    ],
                        ];
                $f = new FilemanagerService($extra);
                $f->run();
        }
    }
    public function postConnection()
    {

        if (!empty(Session::get('cust_id'))) {
              $extra = [
                             "source" => $this->path,
                             "url" => url('/'),
                             "doc_root"=>'',
                             'c_folder' => $this->folder,
                             "ext" => ["jpg","jpeg","gif","png","svg","txt","pdf","odp","ods","odt","rtf","doc","docx","xls","xlsx","ppt","pptx","csv","ogv","mp4","webm","m4v","ogg","mp3","wav","zip","rar"],
                              "upload" => [
                                  "number" => 5,
                                  "overwrite" => false,
                                  "size_max" => 10
                                  ],
                              "images" => [
                                  "images_ext" => ["jpg","jpeg","gif","png"],
                                  "resize" => ["thumbWidth" => 120,"thumbHeight" => 90]
                                  ],
                          ];


            if (isset($_POST['typeFile']) && $_POST['typeFile']=='images') {
                $extra['type_file'] = 'images';
            }
                $f = new FilemanagerService($extra);

                $f->run();
        }
    }

    private function generateGuid()
    {
        $s = strtoupper(md5(uniqid(rand(), true)));
        $guidText =
            substr($s, 0, 8) . '-' .
            substr($s, 8, 4) . '-' .
            substr($s, 12, 4). '-' .
            substr($s, 16, 4). '-' .
            substr($s, 20);
        return $guidText;
    }

    public function retrieveFile($folder, $filename)
    {
        $path = storage_path('customer_files/'.$folder.'/'.$filename);
        $ext  = File::extension($filename);

        $mime = explode('/', mime_content_type($path));

        if ($mime[1] == 'image') {
            Image::make($path)->response();
        } else {
            return Response::make(file_get_contents($path), 200, [
            'Content-Type' => mime_content_type($path),
            'Content-Disposition' => 'inline; filename="'.$filename.'"'
            ]);
        }
    }

    public function retrieveThumb($folder, $filename)
    {
        $path = storage_path('customer_files/'.$folder.'/_thumbs/'.$filename);
        return Image::make($path)->response();
    }
}
