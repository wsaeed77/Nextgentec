<?php namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class ImapGmail
{

  

    function getMessages()
    {
        $hostname = "{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX";

        $username = 'adnan.nexgentec@gmail.com';
        $password = 'word2pass';
       
        $inbox = imap_open($hostname, $username, $password) or die('Cannot connect to Gmail: ' . print_r(imap_errors()));

        /* grab emails */
        $emails = imap_search($inbox, 'UNSEEN');

        if ($emails) {
            //rsort($emails);
            
            /* for every email... */
            foreach ($emails as $email_number) {
                $overview = imap_fetch_overview($inbox, $email_number, 0);
                /* get header of email */
                $header = imap_header($inbox, $email_number, 0);
               
                $structure = imap_fetchstructure($inbox, $email_number);


                $header_info = imap_headerinfo($inbox, $email_number);
                //$header_info = imap_headers( $inbox );

            //dd( $header_info);
                //$mime = imap_fetchmime ($inbox, $email_number);
               // $message = imap_fetchbody($inbox, $email_number,'1.HTML');
                //echo '<pre>';
                //print_r($structure);
                // print_r( $message);
                // exit;
               //dd( $structure);
                $attachments = array();
             
                $files = [];
                  //if(isset($structure->parts) && count($structure->parts) && $structure->type==1) {
                if ($structure->subtype=='MIXED') {
                   //echo "sadasd";exit;
                    for ($i = 1; $i < count($structure->parts); $i++) {
                        if ($structure->parts[$i]->ifparameters) {
                            foreach ($structure->parts[$i]->parameters as $object) {
                                if (strtolower($object->attribute) == 'name') {
                                     $files[] = ['name'=>$object->value,
                                     'mime_type' =>$structure->parts[$i]->subtype];
                                    //$attachments[$i]['name'] = $object->value;

                                     $attachment_binary =imap_fetchbody($inbox, $email_number, $i+1);

                                     if ($structure->parts[$i]->encoding == 3) {
                                          $attachment_obj = base64_decode($attachment_binary);
                                        }

                                     //$fh = fopen(public_path("attachments/$object->value"), "w+");
                                        $fh = fopen(public_path("attachments/$object->value"), "w+");
                                        fwrite($fh, $attachment_obj);
                                        fclose($fh);
                                }
                            }
                        }
                            /* 3 = BASE64 encoding */
                            /*elseif($structure->parts[$i]->encoding == 4) {
                                $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                            }*/
                    }
                    /*if($structure->parts[0]->subtype=='ALTERNATIVE')
                    $message = imap_fetchbody($inbox,$email_number, 1.1);
                   if($structure->parts[0]->subtype=='PLAIN')
                    $message = imap_fetchbody($inbox,$email_number,1);*/

                    $message =  $this->getBody($email_number, $inbox);

                    //$message = $attachment_binary;
                    //dd( $message);
                } else {
                   // $message = imap_fetchbody($inbox, $email_number,1);
                     $message =  $this->getBody($email_number, $inbox);
                }
                $inboxMessage[] = [
                   
                    'body' => $message,
                    'title' => $overview[0]->subject,
                    'revceived_date' => $overview[0]->date,
                    'messageSender' =>$overview[0]->from,
                    'messageSenderEmail' => $header->sender[0]->mailbox.'@'.$header->sender[0]->host,
                    'attachments' =>  $files,
                    'message_id' => $header_info->message_id
                ];
            }
        }
         //print_r( $inboxMessage);
//exit;

        imap_close($inbox);
        return $inboxMessage;
    }
   


    function getBody($uid, $imap)
    {
        $body = $this->get_part($imap, $uid, "TEXT/HTML");
        // if HTML body is empty, try getting text body
        if ($body == "") {
            $body = $this->get_part($imap, $uid, "TEXT/PLAIN");
        }
        return $body;
    }

    function get_part($imap, $uid, $mimetype, $structure = false, $partNumber = false)
    {
        if (!$structure) {
            $structure = imap_fetchstructure($imap, $uid);
        }
        if ($structure) {
            if ($mimetype == $this->get_mime_type($structure)) {
                if (!$partNumber) {
                    $partNumber = 1;
                }
                $text = imap_fetchbody($imap, $uid, $partNumber);
                switch ($structure->encoding) {
                    case 3:
                        return imap_base64($text);
                    case 4:
                        return imap_qprint($text);
                    default:
                        return $text;
                }
            }

            // multipart
            if ($structure->type == 1) {
                foreach ($structure->parts as $index => $subStruct) {
                    $prefix = "";
                    if ($partNumber) {
                        $prefix = $partNumber . ".";
                    }
                    $data = $this->get_part($imap, $uid, $mimetype, $subStruct, $prefix . ($index + 1));
                    if ($data) {
                        return $data;
                    }
                }
            }
        }
        return false;
    }

    function get_mime_type($structure)
    {
        $primaryMimetype = ["TEXT", "MULTIPART", "MESSAGE", "APPLICATION", "AUDIO", "IMAGE", "VIDEO", "OTHER"];

        if ($structure->subtype) {
            return $primaryMimetype[(int)$structure->type] . "/" . $structure->subtype;
        }
        return "TEXT/PLAIN";
    }




    function getThread()
    {
        $hostname = "{imap.gmail.com:993/imap/ssl}INBOX";

        $username = 'adnan.nexgentec@gmail.com';
        $password = 'word2pass';
       
        $inbox = imap_open($hostname, $username, $password) or die('Cannot connect to Gmail: ' . print_r(imap_errors()));

        /* grab emails */
        $emails = imap_thread($inbox);
    //dd($emails);
        foreach ($emails as $key => $val) {
            $tree = explode('.', $key);
            if ($tree[1] == 'num') {
                if ($val!=0) {
                    $header = imap_headerinfo($inbox, $val);
                    echo "<ul>\n\t<li>" . $header->fromaddress . "\n";
                }
            } elseif ($tree[1] == 'branch') {
                        echo "\t</li>\n</ul>\n";
            }
        }

        dd('end');
        if ($emails) {
            //rsort($emails);
            
            /* for every email... */
            foreach ($emails as $key => $email_number) {
                if ($email_number==0) {
                    continue;
                }
                $overview = imap_fetch_overview($inbox, $email_number, 0);
                /* get header of email */
                $header = imap_header($inbox, $email_number, 0);
               
                $structure = imap_fetchstructure($inbox, $email_number);


                $header_info = imap_headerinfo($inbox, $email_number);
                //$header_info = imap_headers( $inbox );

            //dd( $header_info);
                //$mime = imap_fetchmime ($inbox, $email_number);
               // $message = imap_fetchbody($inbox, $email_number,'1.HTML');
               // echo '<pre>';
                //print_r($header_info);
                // print_r( $message);
                // exit;
               //dd( $structure);
                $attachments = array();
             
                $files = [];
                  //if(isset($structure->parts) && count($structure->parts) && $structure->type==1) {
                if ($structure->subtype=='MIXED') {
                   //echo "sadasd";exit;
                    for ($i = 1; $i < count($structure->parts); $i++) {
                        if ($structure->parts[$i]->ifparameters) {
                            foreach ($structure->parts[$i]->parameters as $object) {
                                if (strtolower($object->attribute) == 'name') {
                                     $files[] = ['name'=>$object->value,
                                     'mime_type' =>$structure->parts[$i]->subtype];
                                    //$attachments[$i]['name'] = $object->value;

                                     $attachment_binary =imap_fetchbody($inbox, $email_number, $i+1);

                                     if ($structure->parts[$i]->encoding == 3) {
                                          $attachment_obj = base64_decode($attachment_binary);
                                        }

                                     //$fh = fopen(public_path("attachments/$object->value"), "w+");
                                        $fh = fopen(public_path("attachments/$object->value"), "w+");
                                        fwrite($fh, $attachment_obj);
                                        fclose($fh);
                                }
                            }
                        }
                            /* 3 = BASE64 encoding */
                            /*elseif($structure->parts[$i]->encoding == 4) {
                                $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                            }*/
                    }
                    /*if($structure->parts[0]->subtype=='ALTERNATIVE')
                    $message = imap_fetchbody($inbox,$email_number, 1.1);
                   if($structure->parts[0]->subtype=='PLAIN')
                    $message = imap_fetchbody($inbox,$email_number,1);*/

                    $message =  $this->getBody($email_number, $inbox);

                    //$message = $attachment_binary;
                    //dd( $message);
                } else {
                   // $message = imap_fetchbody($inbox, $email_number,1);
                     $message =  $this->getBody($email_number, $inbox);
                }
                $inboxMessage[] = [
                   
                    'body' => $message,
                    'title' => $overview[0]->subject,
                    'revceived_date' => $overview[0]->date,
                    'messageSender' =>$overview[0]->from,
                    'messageSenderEmail' => $header->sender[0]->mailbox.'@'.$header->sender[0]->host,
                    'attachments' =>  $files,
                    'message_id' => $header_info->message_id
                ];
            }
        }
         //print_r( $inboxMessage);
    //exit;

        imap_close($inbox);
        return $inboxMessage;
    }
}
