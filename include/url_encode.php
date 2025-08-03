<?php

function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64url_decode($data) {
    return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}



// Example usage:

// Encode parameters
// $params = [
//     'page' => 'today_report',
//     'report_type' => 'total',
//     'user_role' => 'mds_adm',
//     'uid' => '4548',
//     'selected_role' => 'User'
// ];

// $encoded_data = base64url_encode(json_encode($params));
// echo 'Encoded Data: ' . $encoded_data . '<br>';

// // Decode parameters
// $decoded_data = json_decode(base64url_decode($encoded_data), true);
// echo 'Decoded Data: ';
// print_r($decoded_data);
?>
