<?php
$output = [];

$upload_folder = __DIR__. '/../uploads';

$ext_map = [
  'image/jpeg' => '.jpg',
  'image/png' => '.png',
    'image/gif' => '.gif',
];

// https://stackoverflow.com/questions/2040240/php-function-to-generate-v4-uuid
function gen_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

        // 16 bits for "time_mid"
        mt_rand( 0, 0xffff ),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand( 0, 0x0fff ) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand( 0, 0x3fff ) | 0x8000,

        // 48 bits for "node"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
}


if(!empty($_FILES) and $ext_map[$_FILES['avatar']['type']]){
    $output['file'] = $_FILES;

    $filename = gen_uuid(). $ext_map[$_FILES['avatar']['type']];
    $output['filename'] = $filename;
    move_uploaded_file(
        $_FILES['avatar']['tmp_name'],
        $upload_folder. '/'. $filename
    );
}

header('Content-Type: application/json');
echo json_encode($output, JSON_UNESCAPED_UNICODE);

// 筆記
// $_Files 是 PHP 的 HTTP 檔案上傳變數，是一種 array
// 參考資料：https://www.php.net/manual/en/reserved.variables.files.php
//
// 還沒做前端，先用 POSTMAN 測試上傳檔案功能。
// avatar, file, filename 都是我們自己設定的變數名稱或 key
//
// PHP 要搬動檔案只有 move_uploaded_file() 可以用
// 參考資料： https://www.php.net/manual/en/function.move-uploaded-file.php
//
// uniqid()
// 用時間（？）產生獨特的 id
// 參考資料： https://www.php.net/manual/en/function.uniqid.php
//
// uuid 產生參考：
// https://stackoverflow.com/questions/2040240/php-function-to-generate-v4-uuid

