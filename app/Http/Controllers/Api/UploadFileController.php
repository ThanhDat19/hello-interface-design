<?php

namespace App\Http\Controllers\Api;

use App\Models\UploadModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadFileController extends Controller
{
    public function demo (Request $request) {
        $arrFiles    = $request->file('files');
        $checkUpload = UploadModel::uploadMultiFile('cardgame', $arrFiles, 1, 'CardGameController', 1, 1);
    }
}
