<?php

function closeConnection($msg2,$format,$invalid_number, $responseCode){
    // Cause we are clever and don't want the rest of the script to be bound by a timeout.
    // Set to zero so no time limit is imposed from here on out.
    set_time_limit(0);

    // Client disconnect should NOT abort our script execution
    ignore_user_abort(true);

    // Clean (erase) the output buffer and turn off output buffering
    // in case there was anything up in there to begin with.
    ob_end_clean();

    // Turn on output buffering, because ... we just turned it off ...
    // if it was on.
    ob_start();
    show_msg($msg2,$format,$invalid_number);
   /* echo $body;*/

    // Return the length of the output buffer
    $size = ob_get_length();

    // send headers to tell the browser to close the connection
    // remember, the headers must be called prior to any actual
    // input being sent via our flush(es) below.
    header("Connection: close\r\n");
    header("Content-Encoding: none\r\n");
    header("Content-Length: $size");

    // Set the HTTP response code
    // this is only available in PHP 5.4.0 or greater
    http_response_code($responseCode);

    // Flush (send) the output buffer and turn off output buffering
    ob_end_flush();

    // Flush (send) the output buffer
    // This looks like overkill, but trust me. I know, you really don't need this
    // unless you do need it, in which case, you will be glad you had it!
    @ob_flush();

    // Flush system output buffer
    // I know, more over kill looking stuff, but this
    // Flushes the system write buffers of PHP and whatever backend PHP is using
    // (CGI, a web server, etc). This attempts to push current output all the way
    // to the browser with a few caveats.
    flush();
}


function show_msg($msg=null,$format=null,$invalid_number=null)
{

    $message=$msg['message'];
    if($invalid_number>0)
    {
         $msg['invalid_number']="Total Invalid numbers  = ".$invalid_number;
    }
   

    if($message=="Message Submitted sent")
    {
        $job_id=$msg['msg-id'];
         if ($format == "json") {
                echo json_encode($msg);
            }else if($format == "xml") {

                    header('Content-type: text/xml');
                    header('Pragma: public');
                    header('Cache-control: private');
                    header('Expires: -1');
                    echo '<?xml version="1.0" encoding="utf-8"?>';
                    echo '<xml>';
                    echo "<response>
                            <message>$message</message>
                            <msgid>$job_id</msgid>
                            <msgid>Total Invalid Numbers: $invalid_number</msgid>
                          </response>";
                    echo '</xml>';
           
                } else {

                echo $message;
                echo '<pre>';
                echo "msg-id : " . $job_id;
                echo '<pre>';
                echo "Total Invalid Numbers : " . $invalid_number;
            }
    }
    else
    {

        if ($format == "json") {
                echo json_encode($msg);
            }
            else if($format == "xml") {

        header('Content-type: text/xml');
        header('Pragma: public');
        header('Cache-control: private');
        header('Expires: -1');
        echo '<?xml version="1.0" encoding="utf-8"?>';
        echo '<xml>';
        echo "<response>
                <message>$message</message>
                 <msgid>Total Invalid Numbers: $invalid_number</msgid>
              </response>";
        echo '</xml>';
                   
            }
            else {
                echo $message;
                 echo '<pre>';
                echo "Total Invalid Numbers : " . $invalid_number;
            }
    }

    
}