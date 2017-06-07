<?php
namespace App\Services;

use GuillermoMartinez\Filemanager\Filemanager;

use URL;

class FilemanagerService extends Filemanager
{
    private $config;
    private $c_folder;
    private $fileDetails = [
        "urlfolder" => '',
        "filename" => "",
        "filetype" => "",
        "isdir" => false,
        "lastmodified" => "",
        "previewfull" => "",
        "preview" => "",
        "size" => "",
        ];

    function __construct($filemanager)
    {
        $this->c_folder = $filemanager['c_folder'];

        
        $this->config = $filemanager;
        parent::__construct($filemanager);
    }


    public function fileInfo($file, $path)
    {
        //dd($path);
        if ($file->isReadable()) {
            $item = $this->fileDetails;
            $item["filename"] = $file->getFilename();
            $item["filetype"] = $file->getExtension();
            $item["lastmodified"] = $file->getMTime();
            $item["size"] = $file->getSize();
            
            if ($file->isDir()) {
                $item["filetype"] = '';
                $item["isdir"] = true;
                $item["urlfolder"] = $path.$item["filename"].'/';
                $item['preview'] = '';
            } elseif ($file->isFile()) {
                $thumb =  $this->createThumb($file, $path);
                $folder = $this->c_folder;
                if ($thumb) {
                     $item['preview'] = url(URL::route('get.user_files.thumb', ['folder' => $folder,'filename' => $path.$thumb]));
                     //original Code
                    //$item['preview'] = $this->config['url'].$this->config['source'].'/_thumbs'.$path.$thumb;
                }
                $item['previewfull'] = url(URL::route('get.user_files.file', ['folder' => $folder,'filename' => $path.$item["filename"]]));
                 //original Code
                //$item['previewfull'] = $this->config['url'].$this->config['source'].$path.$item["filename"];

                //dd(URL::route('get.user_files.thumb', ['folder' => $folder,'filename' => $path.$thumb]));
            }
            return $item;
        } else {
            return ;
        }
    }

    public function upload($file, $path)
    {


        if ($this->validExt($file->getClientOriginalName())) {
            //echo $this->getMaxUploadFileSize();
                //exit;
            if ($file->getClientSize() > ($this->getMaxUploadFileSize() * 1024 * 1024)) {
                $result = ["query"=>"BE_UPLOAD_FILE_SIZE_NOT_SERVER","params"=>[$file->getClientSize()]];
                $this->setInfo(["msg"=>$result]);

                if ($this->config['debug']) {
                    $this->_log(__METHOD__." - file size no permitido server: ".$file->getClientSize());
                }
                return ;
            } elseif ($file->getClientSize() > ($this->config['upload']['size_max'] * 1024 * 1024)) {
                $result = ["query"=>"BE_UPLOAD_FILE_SIZE_NOT_PERMITIDO","params"=>[$file->getClientSize()]];
                $this->setInfo(["msg"=>$result]);

                if ($this->config['debug']) {
                    $this->_log(__METHOD__." - file size no permitido: ".$file->getClientSize());
                }
                return ;
            } else {
                if ($file->isValid()) {
                    $dir = $this->getFullPath().$path;
                    $namefile = $file->getClientOriginalName();
                    //dd($namefile);
                    $namefile = $this->clearNameFile($namefile);

                    $ext = $this->getExtension($namefile);

                    //$nametemp = $namefile;
                    $nametemp = $this->removeExtension($namefile) . '_' .time(). '.' . $ext ;
                    if ($this->config["upload"]["overwrite"] ==false) {
                        $i=0;
                        while (true) {
                            $pathnametemp = $dir.$nametemp;
                            if (file_exists($pathnametemp)) {
                                $i++;
                                //$nametemp = $this->removeExtension( $namefile ) . '_' . $i . '.' . $ext ;
                                $nametemp = $this->removeExtension($namefile) . '_' .time(). '.' . $ext ;
                            } else {
                                break;
                            }
                        }
                    }
                    
                    $file->move($dir, $nametemp);
                    $file = new  \SplFileInfo($dir.$nametemp);
                    return $file;
                }
            }
        } else {
            if ($this->config['debug']) {
                $this->_log(__METHOD__." - file extension no permitido: ".$file->getExtension());
            }
        }
    }
}
