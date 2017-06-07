<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use Storage;
use File;
use URL;
use Image;

class ImageController extends Controller
{
    function imageUpload(Request $request)
    {
        $allowed = array('png', 'jpg', 'gif');
        $rules = [
                'file' => 'required|image|mimes:jpeg,jpg,png,gif'
        ];

        if (!empty($request->image_dir)) {
            if ($request->hasFile('image')) {
                $image_dir = $request->image_dir;
                $file = $request->file('image');

                if (!in_array($file->guessExtension(), $allowed)) {
                      return '{"error":"Invalid File type"}';
                } else {
                        $guid = $this->generateGuid();
                        $fileName = $guid .'.'. $file->guessExtension();
                        $path = storage_path('image_upload/'.$image_dir);

                        // Make image folder if it does not exist
                    if (Storage::MakeDirectory($path, 0775, true)) {
                        if ($file->move($path, $fileName)) {
                            $url = url(URL::route('get.image', ['folder' => $image_dir,'filename' => $fileName]));
                            return json_encode(array(
                                'url' => $url,
                                'dir' => $image_dir,
                                'id' => $fileName
                            ));
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

    public function retrieveImage($folder, $filename)
    {
        $path = storage_path('image_upload/'.$folder.'/'.$filename);
        return Image::make($path)->response();
    }
}
