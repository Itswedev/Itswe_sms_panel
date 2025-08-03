<?php

class common {

     function pre($value) {
        if (is_array($value)) {
            echo'<pre>'; print_r($value); echo'</pre>'; exit();
        } else {
            echo $value; exit();
        }
    }
   
      //Added by Azizur Rahman for template verification
    function checkTemplate($userid = null, $message = null) {
        global $dbc;
        if (!empty($userid) && !empty($message)) {
            $qry = "SELECT REPLACE(REPLACE(template_data, '\r', ''), '\n', 'PRTss1bKuIj2lJMW') AS template_data, `pe_id`, `template_id` FROM `az_template` WHERE `userid` = {$userid};";
            $res = mysqli_query($dbc, $qry);
            if (mysqli_num_rows($res)) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $template = trim($row['template_data']);
                    $template = str_replace(array("&#039;", "&amp;", "&gt;", "&lt;", "&quot;", "/", "+"), array("'", "&", "<", ">", '"', "b", 'b'), $template);
                    $template = str_replace(array('.', '?', '$', '^', '!', '[', ']', '(', ')', '*', '-', '+', '=', '|', '/', '<', '>'), 'b', $template);
                    $template = preg_replace('/\s+/', ' ', preg_replace('/{#(.*?)#}/', '(.{0,30})', $template));
                    $template = str_replace(array('(.{0,30}) (.{0,30})'), '(.{0,30})(.{0,30})', $template);
                    $template = str_replace('PRTss1bKuIj2lJMW', '(.{0,1})', $template);

                    $template = str_replace(array('(.{0,30})(.{0,30})(.{0,30})(.{0,30})(.{0,30})(.{0,30})(.{0,30})(.{0,30})', '(.{0,30})(.{0,30})(.{0,30})(.{0,30})(.{0,30})(.{0,30})(.{0,30})', '(.{0,30})(.{0,30})(.{0,30})(.{0,30})(.{0,30})(.{0,30})', '(.{0,30})(.{0,30})(.{0,30})(.{0,30})(.{0,30})', '(.{0,30})(.{0,30})(.{0,30})(.{0,30})', '(.{0,30})(.{0,30})(.{0,30})', '(.{0,30})(.{0,30})'), array('(.{0,240})', '(.{0,210})', '(.{0,180})', '(.{0,150})', '(.{0,120})', '(.{0,90})', '(.{0,60})'), $template);
                    $template = trim($template);

                    $message = trim($message);
                    $message = str_replace(' \n', '', $message);
                    $message = str_replace('\n', '', $message);
                    $message = str_replace(array('.', '?', '$', '^', '!', '[', ']', '(', ')', '*', '-', '+', '=', '|', '/', '<', '>'), 'b', $message);
                    $message = preg_replace('/\s+/', ' ', $message);
                    $message = trim($message);

                    //echo "Template: ".$template."<br>Message: ".$message."<br><br>"; die;

                    $regexMatched = (bool) preg_match("/^" . $template . "$/mi", $message, $matches);

                    if ($regexMatched) {
                        return array("status" => true, "pe_id" => $row['pe_id'], "template_id" => $row['template_id']);
                        exit();
                    }
                }
                // die;
            }
        }
        return array("status" => false, "pe_id" => "", "template_id" => "");
        exit();
    }

} // end of classs

?>