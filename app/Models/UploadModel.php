<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UploadModel extends Model
{
    public static function uploadMultiFile ($folder, $arrFiles, $child_type, $controller_name, $object_id, $user_action = null) {
        try {
            DB::beginTransaction();
            foreach ($arrFiles as $key => $file) {
                $check_upload = self::_uploadImage($file, $folder, $object_id, $user_action);
                if ($check_upload == false) {
                    return false;
                }
                $path_upload = $check_upload[0];
                $size        = $check_upload[2];
                $extention   = $check_upload[1];

                $data = [
                    'ref_object_id'   => $object_id,
                    'controller_name' => $controller_name,
                    'child_type'      => $child_type,
                    'path'            => $path_upload,
                    'size'            => $size,
                    'extention'       => $extention,
                    'create_user_id'  => $user_action,
                    'create_date'     => date('Y-m-d h:i:s'),
                ];
                Files::create($data);
            }
            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            return false;
        }
    }
    private static function _createFolderImagesIfNotExistpath ($folder) {
        $path = pathUploadFile() . "/files";
        if (!file_exists($path)) {
            mkdir($path,0744);
        }
        $path = pathUploadFile() . "/files/images";
        if (!file_exists($path)) {
            mkdir($path,0744);
        }
        $path = pathUploadFile() . "/files/images/$folder";
        if (!file_exists($path)) {
            mkdir($path,0744);
        }
        return $path;
    }
    private static function _resizeImage($sourceType, $imgWidth, $imgHeight){
        $resizeWidth = 1024;
        $resizeHeight = 1024;
        $r = $imgWidth / $imgHeight;
        if($r >= 1){
            if($imgWidth > $resizeWidth){
                // $resizeWidth = $resizeHeight*($imgWidth / $imgHeight);
                // $resizeHeight = $resizeHeight;

                $resizeWidth = $resizeWidth;
                $resizeHeight =$resizeWidth/($imgWidth / $imgHeight);

                // $resizeWidth = $imgWidth;
            }else{
                $resizeWidth = $imgWidth;
                $resizeHeight = $imgHeight;
            }
        }
        else if($r < 1){
            if($imgHeight > $resizeHeight){
                // $resizeHeight = $resizeWidth/($imgWidth / $imgHeight);
                // $resizeWidth = $resizeWidth;

                $resizeHeight = $resizeHeight;
                $resizeWidth = $resizeHeight*($imgWidth / $imgHeight);
            }else{
                $resizeWidth = $imgWidth;
                $resizeHeight = $imgHeight;
            }
        }
        $imageLayer = imagecreatetruecolor($resizeWidth,$resizeHeight);
        imagecopyresampled($imageLayer, $sourceType, 0, 0, 0, 0, $resizeWidth, $resizeHeight, $imgWidth, $imgHeight);

        return $imageLayer;
    }
    private static function  _find_filesize($file)
    {
        if(substr(PHP_OS, 0, 3) == "WIN")
        {
            exec('for %I in ("'.$file.'") do @echo %~zI', $output);
            $return = $output[0];
        }
        else
        {
            $return = filesize($file);
        }
        return $return;
    }
    private static function _uploadImage ($file, $folder, $object_id, $user_action = null) {
        $fileName  = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extention = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $fileName  = vn_to_str($fileName) . "." .$extention;

        if (!preg_match("/^.*\.(jpg|jpeg|png|svg)$/", $fileName, $matchs)) {
            return false;
        }

        $upload_path       = self::_createFolderImagesIfNotExistpath($folder);
        $fileUpload        = date('dmyhms') . "_" . $object_id . "_" . ($user_action ?? ''). "_". $fileName;
        $upload_final_path = "{$upload_path}/{$fileUpload}";

        // dd($fileUpload);
        $sourceProp  = getimagesize($file);
        $file_type   = $sourceProp[2];
        $file_width  = $sourceProp[0];
        $file_height = $sourceProp[1];
        
        switch ($file_type) {
            case IMAGETYPE_GIF:
                $img_type  = imagecreatefromgif($file);
                $img_layer = self::_resizeImage($img_type,$file_width, $file_height);
                imagegif($img_layer, $upload_final_path);
                break;
            case IMAGETYPE_PNG:
                $img_type  = imagecreatefrompng($file);
                $img_layer = self::_resizeImage($img_type,$file_width, $file_height);
                imagepng($img_layer, $upload_final_path);
                break;
            case IMAGETYPE_JPEG:
                $img_type  = imagecreatefromjpeg($file);
                $img_layer = self::_resizeImage($img_type,$file_width, $file_height);
                imagejpeg($img_layer, $upload_final_path);
                break;
            default:
                # code...
                break;
        }
        if (!file_exists($upload_final_path)) {
            return false;
        }
        $size = self::_find_filesize($upload_final_path);
        return [$upload_final_path, $extention, $size];
    }
}
