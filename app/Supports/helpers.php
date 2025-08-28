<?php

use Tymon\JWTAuth\Contracts\Providers\JWT;

function user(){
    return auth('api')->user();
}
function pathUploadFile() {
    return storage_path();
}
function assetAdmin($str) {
    return asset('admin/'. $str);
}
function assetUser($str) {
    return asset('user/'. $str);
}
function vn_to_str($str){
    $unicode = array(
        'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'D'=>'Đ',
        'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
        'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
        'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
        'd'=>'đ',
        'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
        'i'=>'í|ì|ỉ|ĩ|ị',
        'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
        'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
        'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
    );

    foreach($unicode as $nonUnicode => $uni){
        $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        // $str = str_replace("XE","",$str);
    }
    return $str;
}

function caesarCode($string, $type){
    //$type == 1 -> encode
    //$type == 2 -> decode
    $arrayChar = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P",
                    "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "a", "b", "c", "d", "e", "f", 
                    "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z",
                    "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "-"];
    $returnCharacter = "";
    $currentDate = (int)date("d");
    if($type == 1){
        for($j=0;$j<strlen($string);$j++){
            for($i=0;$i<count($arrayChar);$i++){
                if($string[$j] == $arrayChar[$i]){
                    if($i+$currentDate < count($arrayChar)){
                        $returnCharacter .= $arrayChar[$i+$currentDate]; 
                    }
                    else{
                        $step = $i+$currentDate - count($arrayChar);
                        $returnCharacter .= $arrayChar[$step];
                    }
                }
            }
        }
    }
    if($type == 2){
        for($j=0;$j<strlen(($string));$j++){
            for($i=0;$i<count($arrayChar);$i++){
                if($string[$j] == $arrayChar[$i]){
                    if($i-$currentDate >= 0){
                        $returnCharacter .= $arrayChar[$i-$currentDate];
                    }
                    else{
                        $step = count($arrayChar) + $i-$currentDate;
                        $returnCharacter .= $arrayChar[$step];
                    }
                }
            }
        }
    }
    return $returnCharacter;
}
function _encrypt($string, $additional = null){
    // dd($string);
    if($string != null && $string != 'null'){
        $encryptString = "";
        $encryptArray = [];
        if(preg_match('/([:]{2})|(\*)/',$string)){
            if(preg_match('/([:]{2})/',$string)){
                $newString = explode("::",$string);
                for($i=0;$i<count($newString);$i++){
                    if($newString[$i] != ""){
                        array_push($encryptArray,rtrim(base64_encode($newString[$i]),"="));
                    }
                }
            }
            if(preg_match('/(\*)/',$string)){
                $newString = explode("*",$string);
                for($i=0;$i<count($newString);$i++){
                    if($newString[$i] != ""){
                        array_push($encryptArray,rtrim(base64_encode($newString[$i]),"="));
                    }
                }
            }
        }
        else{
            $encryptString = rtrim(base64_encode($string),"=");
        }
        
        $page = str_replace("/","",explode("/",$_SERVER['REQUEST_URI'])[1]);
        $page = explode("?",$page)[0];
        
        // $addString = "eNcr".$page."YptEd_bY_TNK";
        // if($additional != null){
        //     $addString = "eNcr".$additional."YptEd_bY_TNK";
        // }

        $addString = $page."-bY-TNK";
        if($additional != null){
            $addString = $additional."-bY-TNK";
        }

        $split = explode("-",$addString);
        $encrypted = "";
        if(preg_match('/([:]{2})|(\*)/',$string)){
            if(!empty($encryptArray)){
                for($i=0;$i<count($encryptArray);$i++){
                    $encrypted .= "::".caesarCode($split[0]."-".$encryptArray[$i]."-".$split[1]."-".$split[2],1);
                }
            }
        }
        else{
            $encrypted = caesarCode($split[0]."-".$encryptString."-".$split[1]."-".$split[2],1);
        }          
        
        return $encrypted; 
    }
    else{
        return $string;
    }
}   
function _arrayEncrypt($array, $idColumn = null, $parameter){
    if($idColumn != null){
        foreach($array as $element){
            if(is_array($idColumn)){
                for($i=0; $i<count($idColumn); $i++){
                    $id = $idColumn[$i];
                    if($element->$id != null || $element->$id != ""){
                        $element->$id = _encrypt($element->$id, $parameter);
                    }
                }
            }
            else{
                $element->$idColumn = _encrypt($element->$idColumn, $parameter);
            }
        }  
    }
    else{
        foreach($array as $element){
            $element = _encrypt($element, $parameter);
        }  
    }
    return $array;
}
function _elementEncrypt($array, $idColumn, $parameter){
    if(is_array($array) || is_object($array)){
        for($i=0; $i<count($idColumn); $i++){
            $col = $idColumn[$i];
            if($array[$col] != null || $array[$col] != ""){
                $array[$col] = _encrypt($array[$col], $parameter);
            }
        }
    }
    return $array;
}
function _arrayEncryptOp2($array, $idColumn = null, $parameter){
    if($idColumn != null){
        for ($i=0; $i < count($array); $i++) { 
            if(is_array($idColumn)){
                for($j=0; $j<count($idColumn); $j++){
                    $id = $idColumn[$j];
                    if($array[$i][$id] != null || $array[$i][$id] != ""){
                        $array[$i][$id] = _encrypt($array[$i][$id], $parameter);
                    }
                }
            }
            else{
                $array[$i][$idColumn] = _encrypt($array[$i][$idColumn], $parameter);
            }
        }
    }
    else{
        foreach($array as $element){
            $element = _encrypt($element, $parameter);
        }  
    }
    return $array;
}

function _decrypt($string, $additional = null){
    if($string != null && is_numeric($string) == false && $string != 'null'){
        $decrypt = caesarCode($string, 2);
        $split = explode("-",$decrypt);
//dd($decrypt, $split);      
        // if(isset($split[1])){
        //     $checkSplit = str_replace($split[1],"",$decrypt);
        // }
        // else{
        //     dd($string, $decrypt);
        // }
        if(count($split)>1) {
            $checkSplit = str_replace($split[1],"",$decrypt);
            
            $page = explode("/",$_SERVER['REQUEST_URI'])[1];
            $page = explode("?",$page)[0];
            
            // $checkPage = "eNcr".$page."YptEdbYTNK";
            // if($additional != null){
            //     $checkPage = "eNcr".$additional."YptEdbYTNK";
            // }
            
            $checkPage = $page."bYTNK";
            if($additional != null){
                $checkPage = $additional."bYTNK";
            }
            
            if(str_replace("-","",$checkSplit) != $checkPage){
                return 'Đừng có đổi cái này';
            }
            $decrypted = base64_decode($split[1]);
            return $decrypted;
        }else{
            return -1;
        }
    }
    else{
        return $string;
    }
}



function _arrayDecrypt($array, $idColumn = null, $parameter){
    if($idColumn != null){
        foreach($array as $element){
            if(is_array($idColumn)){
                for($i=0; $i<count($idColumn); $i++){
                    $id = $idColumn[$i];
                    if($element->$id != null || $element->$id != ""){
                        $element->$id = _decrypt($element->$id, $parameter);
                    }
                }
            }
            else{
                $element->$idColumn = _decrypt($element->$idColumn, $parameter);
            }
        }  
    }
    else{
        foreach($array as $element){
            $element = _decrypt($element, $parameter);
        } 
    }
    return $array;
}
function _arrayDecryptOp2($array, $idColumn = null, $parameter){
    if($idColumn != null){
        foreach($array as $element){
            if(is_array($idColumn)){
                for($i=0; $i<count($idColumn); $i++){
                    $id = $idColumn[$i];
                    if($element[$id] != null || $element[$id] != ""){
                        $element[$id] = _decrypt($element[$id], $parameter);
                    }
                }
            }
            else{
                $element[$idColumn] = _decrypt($element[$idColumn], $parameter);
            }
        }  
    }
    else{
        foreach($array as $element){
            $element = _decrypt($element, $parameter);
        } 
    }
    return $array;
}
function _elementDecrypt($array, $idColumn, $parameter){
    if(is_array($array) || is_object($array)){
        for($i=0; $i<count($idColumn); $i++){
            $col = $idColumn[$i];
            if($array[$col] != null || $array[$col] != "" || $array[$col] != "null"){
                $array[$col] = _decrypt($array[$col], $parameter);
            }
        }
    }
    return $array;
}