<?php namespace App\Services;

error_reporting(E_ALL);
ini_set('display_errors', '1');
use Illuminate\Support\Facades\Cache;

//use Illuminate\Support\Facades\Config;

use App\Model\Config;

class GoogleGmail
{

    protected $client;

    protected $service;
    protected $user = 'me';
    //protected $credentialsPath;

    protected $scopes ;
    public $auth_url;

    function __construct($flag = null, $token = null)
    {
        $auth_key =  Config::where('key', 'gmail_auth_client_id')->first();
        $auth_secret =  Config::where('key', 'gmail_auth_client_secret')->first();
        $redirect_uri =  Config::where('key', 'redirect_uri')->first();

        $this->scopes = implode(' ', [ \Google_Service_Gmail::GMAIL_READONLY, \Google_Service_Gmail::GMAIL_COMPOSE,\Google_Service_Gmail::GMAIL_SEND]);

        $this->client = new \Google_Client();
        $this->client->setApplicationName(\Config::get('google.application_name'));
        $this->client->setScopes($this->scopes);
        $this->client->setClientId($auth_key->value);
        $this->client->setClientSecret($auth_secret->value);
        $this->client->setRedirectUri($redirect_uri->value);
        //$this->client->setAuthConfigFile(base_path() .Config::get('google.client_secret_path'));
        $this->client->setAccessType('offline');





        if ($flag=='reset') {
           // $client->setApprovalPrompt('auto');
            $this->client->setPrompt('consent');
            //$client->revokeToken($accessToken);
            $this->auth_url = $this->client->createAuthUrl();
            //dd(json_decode($this->auth_url));

            return true;
        }

        if ($flag=='token_reset' && isset($token)) {
            $returnedAccessToken =  $this->client->authenticate($token);
             //$accessToken =  $this->client->getAccessToken();
             //dd($accessToken);
             //if(!file_exists(dirname($credentialsPath))) {
             // mkdir(dirname($credentialsPath), 0700, true);
            //}
            $file_path = base_path('resources/assets');

            $file =  $file_path."/gmail_token.json";
            file_put_contents($file, $returnedAccessToken);
            //echo ("Credentials saved to ==>".$credentialsPath);

            return true;
        }


        $credentialsPath = base_path() .\Config::get('google.credentials_path');
       // dd($credentialsPath);
        if (file_exists($credentialsPath)) {
            //echo 'hhhh';
            //exit;
            //echo $credentialsPath;
              $accessToken = file_get_contents($credentialsPath);

              $google_token= json_decode($accessToken);
              // dd($google_token->refresh_token);
            //$this->client->setAccessToken($accessToken);
              $this->client->refreshToken($google_token->refresh_token);

              $this->client->setAccessToken($accessToken);

              $this->service = new \Google_Service_Gmail($this->client);
        }
    }

    /*function setCredentials()
    {

         $this->scopes = implode(' ', array( \Google_Service_Gmail::GMAIL_READONLY, \Google_Service_Gmail::GMAIL_COMPOSE,\Google_Service_Gmail::GMAIL_SEND));

        $this->client = new \Google_Client();
        $this->client->setApplicationName(Config::get('google.application_name'));
        $this->client->setScopes($this->scopes);
        $this->client->setAuthConfigFile(base_path() .Config::get('google.client_secret_path'));
        $this->client->setAccessType('offline');

        //$credentialsPath = base_path() .Config::get('google.credentials_path');
        //$key_file_location = base_path() . Config::get('google.credentials_path');

       
        // Request authorization from the user.
        $authUrl = $this->client->createAuthUrl();
        printf("Open the following link in your browser:\n%s\n", $authUrl);
        print 'Enter verification code: ';
        //return $authUrl;
        //exit;
        $authCode = trim(fgets(STDIN));

        // Exchange authorization code for an access token.
        $accessToken = $this->client->authenticate($authCode);

        // Store the credentials to disk.
        if(!file_exists(dirname($credentialsPath))) {
          mkdir(dirname($credentialsPath), 0700, true);
        }
        file_put_contents($credentialsPath, $accessToken);
        printf("Credentials saved to %s\n", $credentialsPath);
       
       
        $this->client->setAccessToken($accessToken);
        $this->service = new \Google_Service_Gmail($this->client);

    }*/


    function getMessages()
    {
        $list = $this->service->users_messages->listUsersMessages($this->user, ['maxResults' => 10,'labelIds'=>'INBOX','q'=>'is:unread']);
        //echo '<pre>';
        $messageList = $list->getMessages();
        $inboxMessage = [];
        //dd($messageList);
        foreach ($messageList as $mlist) {
            $optParamsGet2['format'] = 'full';
            //$optParamsGet2['labelIds'] = 'INBOX';

            $single_message = $this->service->users_messages->get($this->user, $mlist->id, $optParamsGet2);

            /**************************************** new code*********************/
            $payload = $single_message->getPayload();
            $parts = $payload->getParts();
            // With no attachment, the payload might be directly in the body, encoded.
            $body = $payload->getBody();
            $FOUND_BODY = false;
            if (!$FOUND_BODY) {
                foreach ($parts as $part) {
                    if ($part['parts'] && !$FOUND_BODY) {
                        foreach ($part['parts'] as $p) {
                            if ($p['parts'] && count($p['parts']) > 0) {
                                foreach ($p['parts'] as $y) {
                                    if (($y['mimeType'] === 'text/html') && $y['body']) {
                                        $FOUND_BODY = decodeBody($y['body']->data);
                                        break;
                                    }
                                }
                            } else if (($p['mimeType'] === 'text/html') && $p['body']) {
                                $FOUND_BODY = decodeBody($p['body']->data);
                                break;
                            }
                        }
                    }
                    if ($FOUND_BODY) {
                        break;
                    }
                }
            }
            if ($FOUND_BODY && count($parts) > 1) {
                $images_linked = [];
                foreach ($parts as $part) {
                    if ($part['filename']) {
                        array_push($images_linked, $part);
                    } else {
                        if ($part['parts']) {
                            foreach ($part['parts'] as $p) {
                                if ($p['parts'] && count($p['parts']) > 0) {
                                    foreach ($p['parts'] as $y) {
                                        if (($y['mimeType'] === 'text/html') && $y['body']) {
                                            array_push($images_linked, $y);
                                        }
                                    }
                                } else if (($p['mimeType'] !== 'text/html') && $p['body']) {
                                    array_push($images_linked, $p);
                                }
                            }
                        }
                    }
                }
                // special case for the wdcid...
                preg_match_all('/wdcid(.*)"/Uims', $FOUND_BODY, $wdmatches);
                if (count($wdmatches)) {
                    $z = 0;
                    foreach ($wdmatches[0] as $match) {
                        $z++;
                        if ($z > 9) {
                            $FOUND_BODY = str_replace($match, 'image0' . $z . '@', $FOUND_BODY);
                        } else {
                            $FOUND_BODY = str_replace($match, 'image00' . $z . '@', $FOUND_BODY);
                        }
                    }
                }
                preg_match_all('/src="cid:(.*)"/Uims', $FOUND_BODY, $matches);
                if (count($matches)) {
                    $search = [];
                    $replace = [];
                    // let's trasnform the CIDs as base64 attachements
                    foreach ($matches[1] as $match) {
                        foreach ($images_linked as $img_linked) {
                            foreach ($img_linked['headers'] as $img_lnk) {
                                if ($img_lnk['name'] === 'Content-ID' || $img_lnk['name'] === 'Content-Id' || $img_lnk['name'] === 'X-Attachment-Id') {
                                    if ($match === str_replace('>', '', str_replace('<', '', $img_lnk->value))
                                        || explode("@", $match)[0] === explode(".", $img_linked->filename)[0]
                                        || explode("@", $match)[0] === $img_linked->filename) {
                                        $search = "src=\"cid:$match\"";
                                        $mimetype = $img_linked->mimeType;
                                        $attachment = $gmail->users_messages_attachments->get('me', $mlist->id, $img_linked['body']->attachmentId);
                                        $data64 = strtr($attachment->getData(), ['-' => '+', '_' => '/']);
                                        $replace = "src=\"data:" . $mimetype . ";base64," . $data64 . "\"";
                                        $FOUND_BODY = str_replace($search, $replace, $FOUND_BODY);
                                    }
                                }
                            }
                        }
                    }
                }
            }
            // If we didn't find the body in the last parts,
            // let's loop for the first parts (text-html only)
            if (!$FOUND_BODY) {
                foreach ($parts as $part) {
                    if ($part['body'] && $part['mimeType'] === 'text/html') {
                        $FOUND_BODY = decodeBody($part['body']->data);
                        break;
                    }
                }
            }
            // With no attachment, the payload might be directly in the body, encoded.
            if (!$FOUND_BODY) {
                $FOUND_BODY = decodeBody($body['data']);
            }
            // Last try: if we didn't find the body in the last parts,
            // let's loop for the first parts (text-plain only)
            if (!$FOUND_BODY) {
                foreach ($parts as $part) {
                    if ($part['body']) {
                        $FOUND_BODY = decodeBody($part['body']->data);
                        break;
                    }
                }
            }
            if (!$FOUND_BODY) {
                $FOUND_BODY = '(No message)';
            }
            // Finally, print the message ID and the body
            dd($message_id . ": " . $FOUND_BODY);

        /**************************************** End new code*********************/
            $message_id = $mlist->id;
            $headers = $single_message->getPayload()->getHeaders();
            $snippet = htmlentities($single_message->getSnippet());

        //var_dump( $single_message);
            $message_sender_email ='';
            foreach ($headers as $single) {
                if ($single->getName() == 'Subject') {
                    $message_subject = $single->getValue();
                } else if ($single->getName() == 'Date') {
                    $message_date = $single->getValue();
                    $message_date = date('M jS Y h:i A', strtotime($message_date));
                } else if ($single->getName() == 'From') {
                    $message_sender_email = htmlentities($single->getValue());
                    $message_sender= $single->getValue();
                    $message_sender = str_replace('"', '', $message_sender);
                } else if ($single->getName() == 'X-Sender-Id') {
                    $message_sender_email = $single->getValue();
                    //$message_sender = str_replace('"', '', $message_sender);
                }
            }
            $files = [];

            foreach ($single_message->getPayload()->getParts() as $part) {
                if ($part->filename && $part->filename!='') {
                    //echo $part->getMimeType();
                    $data = $this->service->users_messages_attachments->get('me', $mlist->id, $part->getBody()->getAttachmentId());

                    $file_name = $part->getFilename();

                    $data1 = strtr($data->getData(), ['-' => '+', '_' => '/']);
                    $fh = fopen(public_path("attachments/$file_name"), "w+");
                         //fwrite($fh, base64_decode($data->data));

                    fwrite($fh, base64_decode(utf8_encode($data1)));
                    fclose($fh);

                    $files[] = ['name'=>$file_name,
                    'mime_type' =>$part->mimeType];
                }
            }
        //$sss = explode('<', $message_sender);
            preg_match("/&lt;(.*)&gt;/", $message_sender_email, $output_array);
        //dd($regularExpression);
            $inboxMessage[] = [
            'messageId' => $message_id,
            'body' => $snippet,
            'title' => $message_subject,
            'revceived_date' => $message_date,
            'messageSender' => $message_sender,
            'messageSenderEmail' => $output_array[1],
            'attachments' =>  $files
            ];
        }
        echo '<pre>';
        print_r($inboxMessage);
        exit;
        //return $inboxMessage;
            /*echo '<pre>';
            print_r($inboxMessage);

            exit;*/
    }

    function send_mail($mime, $threadId)
    {


        $message = new \Google_Service_Gmail_Message();

        $message->setThreadId($threadId);
        $message->setRaw($mime);

        $this->service->users_messages->send('me', $message);
    }


    function getThreads()
    {

     //$url = "https://www.googleapis.com/gmail/v1/users/me/threads/key=AIzaSyBy7UHFP-582phhFoaECeEw2tL5Z_J9D2o";
       // dd($this->service);
        $threads =[];
        $threads_msgs =[];
        $threadsResponse = $this->service->users_threads->listUsersThreads('me', ['maxResults' => 10,'labelIds'=>'INBOX','q'=>'is:unread']);
        if ($threadsResponse->getThreads()) {
            $threads = array_merge($threads, $threadsResponse->getThreads());
            //$pageToken = $threadsResponse->getNextPageToken();
        }
      //dd($threads);
        //echo '<pre>';
        foreach ($threads as $thread) {
       // print 'Thread with ID: ' . $thread->getId() . '<br/>';
            $thread =  $this->service->users_threads->get('me', $thread->getId(), ['format'=>'full']);
            $messages = $thread->getMessages();
//dd($messages);

            foreach ($messages as $mlist) {
                  /**************************************** new code*********************/
                  $optParamsGet2['format'] = 'full';
                  //$optParamsGet2['labelIds'] = 'INBOX';

                  $single_message = $this->service->users_messages->get($this->user, $mlist->id, $optParamsGet2);


                  $payload = $single_message->getPayload();
                  $parts = $payload->getParts();
                  // With no attachment, the payload might be directly in the body, encoded.
                  $body = $payload->getBody();
                  $FOUND_BODY = false;
                if (!$FOUND_BODY) {
                    foreach ($parts as $part) {
                        if ($part['parts'] && !$FOUND_BODY) {
                            foreach ($part['parts'] as $p) {
                                if ($p['parts'] && count($p['parts']) > 0) {
                                    foreach ($p['parts'] as $y) {
                                        if (($y['mimeType'] === 'text/html') && $y['body']) {
                                            $FOUND_BODY = $this->decodeBody($y['body']->data);
                                            break;
                                        }
                                    }
                                } else if (($p['mimeType'] === 'text/html') && $p['body']) {
                                    $FOUND_BODY = $this->decodeBody($p['body']->data);
                                    break;
                                }
                            }
                        }
                        if ($FOUND_BODY) {
                            break;
                        }
                    }
                }
                if ($FOUND_BODY && count($parts) > 1) {
                     $images_linked = [];
                    foreach ($parts as $part) {
                        if ($part['filename']) {
                            array_push($images_linked, $part);
                        } else {
                            if ($part['parts']) {
                                foreach ($part['parts'] as $p) {
                                    if ($p['parts'] && count($p['parts']) > 0) {
                                        foreach ($p['parts'] as $y) {
                                            if (($y['mimeType'] === 'text/html') && $y['body']) {
                                                array_push($images_linked, $y);
                                            }
                                        }
                                    } else if (($p['mimeType'] !== 'text/html') && $p['body']) {
                                        array_push($images_linked, $p);
                                    }
                                }
                            }
                        }
                    }
                       // special case for the wdcid...
                        preg_match_all('/wdcid(.*)"/Uims', $FOUND_BODY, $wdmatches);
                    if (count($wdmatches)) {
                        $z = 0;
                        foreach ($wdmatches[0] as $match) {
                            $z++;
                            if ($z > 9) {
                                $FOUND_BODY = str_replace($match, 'image0' . $z . '@', $FOUND_BODY);
                            } else {
                                $FOUND_BODY = str_replace($match, 'image00' . $z . '@', $FOUND_BODY);
                            }
                        }
                    }
                        preg_match_all('/src="cid:(.*)"/Uims', $FOUND_BODY, $matches);
                    if (count($matches)) {
                        $search = [];
                        $replace = [];
                        // let's trasnform the CIDs as base64 attachements
                        foreach ($matches[1] as $match) {
                            foreach ($images_linked as $img_linked) {
                                foreach ($img_linked['headers'] as $img_lnk) {
                                    if ($img_lnk['name'] === 'Content-ID' || $img_lnk['name'] === 'Content-Id' || $img_lnk['name'] === 'X-Attachment-Id') {
                                        if ($match === str_replace('>', '', str_replace('<', '', $img_lnk->value))
                                        || explode("@", $match)[0] === explode(".", $img_linked->filename)[0]
                                        || explode("@", $match)[0] === $img_linked->filename) {
                                            $search = "src=\"cid:$match\"";
                                            $mimetype = $img_linked->mimeType;
                                            $attachment = $this->service->users_messages_attachments->get('me', $mlist->id, $img_linked['body']->attachmentId);
                                            $data64 = strtr($attachment->getData(), ['-' => '+', '_' => '/']);
                                            $replace = "src=\"data:" . $mimetype . ";base64," . $data64 . "\"";
                                            $FOUND_BODY = str_replace($search, $replace, $FOUND_BODY);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                  // If we didn't find the body in the last parts,
                  // let's loop for the first parts (text-html only)
                if (!$FOUND_BODY) {
                    foreach ($parts as $part) {
                        if ($part['body'] && $part['mimeType'] === 'text/html') {
                            $FOUND_BODY = $this->decodeBody($part['body']->data);
                            break;
                        }
                    }
                }
                  // With no attachment, the payload might be directly in the body, encoded.
                if (!$FOUND_BODY) {
                    $FOUND_BODY = $this->decodeBody($body['data']);
                }
                  // Last try: if we didn't find the body in the last parts,
                  // let's loop for the first parts (text-plain only)
                if (!$FOUND_BODY) {
                    foreach ($parts as $part) {
                        if ($part['body']) {
                            $FOUND_BODY = $this->decodeBody($part['body']->data);
                            break;
                        }
                    }
                }
                if (!$FOUND_BODY) {
                    $FOUND_BODY = '(No message)';
                }
                  // Finally, print the message ID and the body
                  //dd( $FOUND_BODY);

              /**************************************** End new code*********************/
              //dd($mlist);


                $message_id = $mlist->id;
                $headers = $mlist->getPayload()->getHeaders();
                $snippet = htmlentities($mlist->getSnippet());
      //echo '<pre>';
      //print_r( $headers);
      //var_dump( $mlist);
                $message_sender_email ='';
                $response_id = '';
                foreach ($headers as $single) {
             //dd($single);
                    if ($single->getName() == 'Subject') {
                        $message_subject = $single->getValue();
                    } else if ($single->getName() == 'Message-ID') {
                        $gmail_msg_id = $single->getValue();
                    } else if ($single->getName() == 'response_id') {
                        $response_id = $single->getValue();
                    } else if ($single->getName() == 'Date') {
                        $message_date = $single->getValue();
                         // $message_date = date('M jS Y h:i A', strtotime($message_date)+(5*60*60));
                        $message_date = date('M jS Y h:i A', strtotime($message_date));
                    } else if ($single->getName() == 'From') {
                        $message_sender_email = htmlentities($single->getValue());
                        $message_sender= $single->getValue();
                        $message_sender = str_replace('"', '', $message_sender);
                    } else if ($single->getName() == 'X-Sender-Id') {
                        $message_sender_email = $single->getValue();
                          //$message_sender = str_replace('"', '', $message_sender);
                    }
                }
                $files = [];

                foreach ($mlist->getPayload()->getParts() as $part) {
                    if ($part->filename && $part->filename!='') {
                           //echo $part->getMimeType();
                        $data = $this->service->users_messages_attachments->get('me', $mlist->id, $part->getBody()->getAttachmentId());

                        $file_name = $part->getFilename();

                        $data1 = strtr($data->getData(), ['-' => '+', '_' => '/']);
                        $fh = fopen(public_path("attachments/$file_name"), "w+");
                          //fwrite($fh, base64_decode($data->data));

                        fwrite($fh, base64_decode(utf8_encode($data1)));
                        fclose($fh);

                        $files[] = ['name'=>$file_name,
                        'mime_type' =>$part->mimeType];
                    }
                }
      //$sss = explode('<', $message_sender);
                preg_match("/&lt;(.*)&gt;/", $message_sender_email, $output_array);
      //dd($regularExpression);
                $threads_msgs[$thread->getId()][] = [
                'messageId' => $message_id,
                'gmail_msg_id' => $gmail_msg_id,
                    //'body' => $snippet,
                'body' => $FOUND_BODY,
                'title' => $message_subject,
                'revceived_date' => date('Y-m-d H:i:s', strtotime($message_date)),
                'messageSender' => $message_sender,
                'response_id' => $response_id,
                'messageSenderEmail' => $output_array[1],
                'attachments' =>  $files
                ];
            }
        }
      //exit;
      //dd($threads_msgs);
        return $threads_msgs;
        exit;
    }



    function decodeBody($body)
    {
        $rawData = $body;
        $sanitizedData = strtr($rawData, '-_', '+/');
        $decodedMessage = base64_decode($sanitizedData);
        if (!$decodedMessage) {
            $decodedMessage = false;
        }
        return $decodedMessage;
    }

    function modifyEmail()
    {
        $modify = new \Google_Service_Gmail_ModifyThreadRequest();
        $modify->setRemoveLabelIds(["UNREAD"]);
    

        $message = $this->service->users_threads->modify('me', 20, $modify);
    }
}
