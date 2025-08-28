<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CardResource;
use App\Models\Card;
use App\Models\CardHistory;
use App\Models\CardType;
use App\Models\NextCode;
use App\Models\UploadModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Unique;

class CardAPIController extends Controller
{
    private function _getData(Request $request) {
        $limit = $request->get('length',20);
        $start = $request->start;

        $data = Card::with([
            'cardType:card_type_id,card_type_name',
            'createUser:user_id,nickname',
            'updateUser:user_id,nickname'
        ])->select(
            'tbl_card.card_id',
            'tbl_card.card_code',
            'tbl_card.card_name',
            'tbl_card.card_type_id',
            'tbl_card.description',
            'tbl_card.defense_stat',
            'tbl_card.magic_stat',
            'tbl_card.attack_stat',
            'tbl_card.dodge_stat',
            'tbl_card.create_user_id',
            'tbl_card.create_date',
            'tbl_card.update_user_id',
            'tbl_card.update_date',
        );
        
        $countTotal = (clone $data)->count();
        $data = $data->orderBy('tbl_card.card_name');
        $data = $data->limit($limit)->offset($start)->get();
        return [$data, $countTotal];
    }
    
    public function getData (Request $request) {
        $dataResult = $this->_getData($request);
        $countTotal = $dataResult[1];
        $data       = $dataResult[0];
        $data       = CardResource::collection($data);
        $count      = count($data);
        return response()->json([
            'recordsTotal'    => $countTotal,
            'recordsFiltered' => $countTotal,
            'data'            => $data,
            'total'           => $count
        ]) ;
    }
    private function _validateData ($data) {
        Validator::extend('check_unique_card_name', function($attribute, $value, $parameter, $validate) {
            $checkExists = Card::where('card_name', $value)->first();
            if ($checkExists) {
                return false;
            }
            return true;

        });
        Validator::extend('check_exists_card_type', function($attribute, $value, $parameter, $validate) {
            $id = _decrypt($value, CardType::KEY_CRYPT);

            $checkExists = CardType::find($id);
            if (!$checkExists) {
                return false;
            }
            return true;

        });
        $rules = [
            'card_name'    => ['bail','required','check_unique_card_name:card_name'],
            'card_type_id' => ['bail','required', 'check_exists_card_type:card_type_id'],
            'attack_stat'  => ['bail','numeric', 'min:0'],
            'magic_stat'   => ['bail','numeric', 'min:0'],
            'defense_stat' => ['bail','numeric', 'min:0'],
            'support_stat' => ['bail','numeric', 'min:0'],
            'dodge_stat'   => ['bail','numeric', 'min:0'],
            'files.*'      => ['file', 'mimes:jpg,jpeg,png,svg,gif'],
        ];
        $messages = [
            '*.required'             => ':attribute không được để trống',
            'check_unique_card_name' => 'Tên thẻ đã tồn tại',
            'check_exists_card_type' => 'Loại thẻ không tồn tại',
            '*.numeric'              => ':attribute phải là số',
            '*.min'                  => 'Không được nhỏ hơn :min',
            'mimes'                  => 'Chỉ được tải file có đuôi jpg, jpeg, png, svg, gif',
        ];
        $attributes = [
            'card_name'    => 'Tên thẻ',
            'card_type_id' => 'Loại thẻ',
            'attack_stat'  => 'Điểm tấn công',
            'magic_stat'   => 'Điểm phép',
            'defense_stat' => 'Điểm phòng thủ',
            'support_stat' => 'Điểm hỗ trợ',
            'dodge_stat'   => 'Điểm né',
        ];
        $validator = Validator::make($data, $rules, $messages, $attributes);
        if ($validator->fails()) {
            return ['status' => false, 'errors' => $validator->errors()->toArray()];
        }
        return ['status' => true, 'errors' => []];
    }
    public function create (Request $request) {
        
        $data    = [
            'card_name'    => $request->card_name,
            'card_type_id' => $request->card_type_id,
            'description'  => $request->description,
            'attack_stat'  => $request->attack_stat,
            'magic_stat'   => $request->magic_stat,
            'defense_stat' => $request->defense_stat,
            'support_stat' => $request->support_stat,
            'dodge_stat'   => $request->dodge_stat,
            'files'        => $request->file('files'),
        ];
       
        $validator = $this->_validateData($data);
        if (!$validator['status']) {
            return response()->json([
                'status'   => 'error',
                'code'     => 400,
                'messages' => 'Dữ liệu không hợp lệ',
                'errors'   => $validator['errors'],
            ]);
        }

        
       
        
        try {
            DB::beginTransaction();
            $user                  = user();
            $user_id               = $user->user_id;
            $card_code             = NextCode::createCode(Card::KEY_TABLE, Card::CODE);
            
            $files = $data['files'];
            unset($data['files']);

            $data['card_type_id']  = _decrypt($data['card_type_id'], CardType::KEY_CRYPT);
            $data                 += [
                'card_code'      => $card_code,
                'create_user_id' => $user_id,
                'create_date'    => date('Y-m-d H:i:s'),
            ];
            
            // Create Card
            $card = Card::create($data);


            // Thêm ảnh 
            if ($files) {
                $checkUpload =  UploadModel::uploadMultiFile(Card::FOLDER_FILE, $files, 1, Card::CONTROLLER_NAME, $card->card_id, $user_id);
                if (!$checkUpload) {
                    return response()->json([
                        'success'    => false,
                        'code'       => 500,
                        'check_file' => $checkUpload,
                        'messages'   => 'Không thể lưu file! Vui lòng thử lại sau',
                    ]);
                }
            }
            

            // Create history
            $dataHistory = $card->toArray();
            $dataHistory += [
                'version'     => 1,
                'ref_card_id' => $card['card_id'],
            ];
            unset($dataHistory['card_id']);
            $carHistory = CardHistory::create($dataHistory);

            DB::commit();
            return response()->json([
                'success'  => true,
                'code'     => 200,
                'messages' => 'Thêm mới dữ liệu thành công',
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            dd($th);
            return response()->json([
                'success'  => false,
                'code'     => 500,
                'messages' => 'Lỗi! Vui lòng liên hệ admin',
            ]);
        }


    }

    
}
