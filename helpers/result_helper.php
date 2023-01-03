<?php

require_once('/var/www/html/kursach2/models/user_model.php');

function return_ok($data, $code)
{
    http_response_code($code);
    $result = array(
        "ok" => true,
        "result" => $data
    );
    header('Content-Type: application/json');
    echo json_encode_objs($result);
}

function return_error($detail, $code)
{
    http_response_code($code);
    $result = array(
        "ok" => false,
        "detail" => $detail,
        "code" => $code
    );
    header('Content-Type: application/json');
    echo json_encode_objs($result);
}

function json_encode_objs($item)
{
    if (!is_array($item) && !is_object($item)) {
        return json_encode($item);
    } else {
        $pieces = array();
        foreach ($item as $k => $v) {
            $pieces[] = "\"$k\":" . json_encode_objs($v);
        }
        return '{' . implode(',', $pieces) . '}';
    }
}
