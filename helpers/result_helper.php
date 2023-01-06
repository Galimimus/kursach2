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
    die();
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
    die();
}

function json_encode_objs($item)
{
    if (is_object($item) || (is_array($item)&&isAssoc($item))) {
        $pieces = array();
        foreach ($item as $k => $v) {
            $pieces[] = "\"$k\":" . json_encode_objs($v);
        }
        return '{' . implode(',', $pieces) . '}';
    } else if(is_array($item)) {
        $pieces = array();
        foreach ($item as $k => $v) {
            $pieces[] = json_encode_objs($v);
        }
        return '[' . implode(',', $pieces) . ']';
    }else{
        return json_encode($item);
    }

}


function isAssoc(array $arr)
{
    if (array() === $arr) return false;
    return array_keys($arr) !== range(0, count($arr) - 1);
}