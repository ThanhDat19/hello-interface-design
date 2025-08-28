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
        $limit = $request->get('length', 20);
        $start = $request->start;

        $query = Card::with([
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
            'tbl_card.support_stat',
            'tbl_card.attack_stat',
            'tbl_card.dodge_stat',
            'tbl_card.create_user_id',
            'tbl_card.create_date',
            'tbl_card.update_user_id',
            'tbl_card.update_date',
        );

        // Advanced search and filters
        if ($request->has('search') && !empty($request->search['value'])) {
            $searchTerm = $request->search['value'];
            $query->where(function($q) use ($searchTerm) {
                $q->where('tbl_card.card_name', 'like', "%{$searchTerm}%")
                  ->orWhere('tbl_card.card_code', 'like', "%{$searchTerm}%")
                  ->orWhere('tbl_card.description', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by card name
        if ($request->has('card_name') && !empty($request->card_name)) {
            $query->where('tbl_card.card_name', 'like', "%{$request->card_name}%");
        }

        // Filter by card type
        if ($request->has('card_type_id') && !empty($request->card_type_id)) {
            $cardTypeId = is_numeric($request->card_type_id) ? $request->card_type_id : _decrypt($request->card_type_id, CardType::KEY_CRYPT);
            $query->where('tbl_card.card_type_id', $cardTypeId);
        }

        // Filter by stats (min-max ranges)
        if ($request->has('attack_min') && is_numeric($request->attack_min)) {
            $query->where('tbl_card.attack_stat', '>=', $request->attack_min);
        }
        if ($request->has('attack_max') && is_numeric($request->attack_max)) {
            $query->where('tbl_card.attack_stat', '<=', $request->attack_max);
        }

        if ($request->has('defense_min') && is_numeric($request->defense_min)) {
            $query->where('tbl_card.defense_stat', '>=', $request->defense_min);
        }
        if ($request->has('defense_max') && is_numeric($request->defense_max)) {
            $query->where('tbl_card.defense_stat', '<=', $request->defense_max);
        }

        if ($request->has('magic_min') && is_numeric($request->magic_min)) {
            $query->where('tbl_card.magic_stat', '>=', $request->magic_min);
        }
        if ($request->has('magic_max') && is_numeric($request->magic_max)) {
            $query->where('tbl_card.magic_stat', '<=', $request->magic_max);
        }

        if ($request->has('support_min') && is_numeric($request->support_min)) {
            $query->where('tbl_card.support_stat', '>=', $request->support_min);
        }
        if ($request->has('support_max') && is_numeric($request->support_max)) {
            $query->where('tbl_card.support_stat', '<=', $request->support_max);
        }

        if ($request->has('dodge_min') && is_numeric($request->dodge_min)) {
            $query->where('tbl_card.dodge_stat', '>=', $request->dodge_min);
        }
        if ($request->has('dodge_max') && is_numeric($request->dodge_max)) {
            $query->where('tbl_card.dodge_stat', '<=', $request->dodge_max);
        }

        // Sorting
        $orderBy = $request->get('order_by', 'card_name');
        $orderDir = $request->get('order_dir', 'asc');
        
        $allowedOrderBy = ['card_name', 'card_code', 'attack_stat', 'defense_stat', 'magic_stat', 'support_stat', 'dodge_stat', 'create_date'];
        if (in_array($orderBy, $allowedOrderBy)) {
            $query->orderBy("tbl_card.{$orderBy}", $orderDir);
        } else {
            $query->orderBy('tbl_card.card_name', 'asc');
        }
        
        $countTotal = (clone $query)->count();
        $data = $query->limit($limit)->offset($start)->get();
        
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
    private function _validateData($data) {
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
            'attack_stat'  => ['bail','numeric', 'min:0', 'max:999'],
            'magic_stat'   => ['bail','numeric', 'min:0', 'max:999'],
            'defense_stat' => ['bail','numeric', 'min:0', 'max:999'],
            'support_stat' => ['bail','numeric', 'min:0', 'max:999'],
            'dodge_stat'   => ['bail','numeric', 'min:0', 'max:999'],
            'files.*'      => ['file', 'mimes:jpg,jpeg,png,svg,gif', 'max:5120'],
        ];

        $messages = [
            '*.required'             => ':attribute không được để trống',
            'check_unique_card_name' => 'Tên thẻ đã tồn tại',
            'check_exists_card_type' => 'Loại thẻ không tồn tại',
            '*.numeric'              => ':attribute phải là số',
            '*.min'                  => ':attribute không được nhỏ hơn :min',
            '*.max'                  => ':attribute không được lớn hơn :max',
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

    private function _validateDataForUpdate($data, $cardId = null) {
        Validator::extend('check_unique_card_name_update', function($attribute, $value, $parameter, $validate) use ($cardId) {
            $checkExists = Card::where('card_name', $value)->where('card_id', '!=', $cardId)->first();
            if ($checkExists) {
                return false;
            }
            return true;
        });

        Validator::extend('check_exists_card_type', function($attribute, $value, $parameter, $validate) {
            if (empty($value)) return true; // Allow empty for updates
            $id = _decrypt($value, CardType::KEY_CRYPT);
            $checkExists = CardType::find($id);
            if (!$checkExists) {
                return false;
            }
            return true;
        });

        $rules = [
            'card_name'    => ['bail','required','check_unique_card_name_update:card_name'],
            'card_type_id' => ['bail','check_exists_card_type:card_type_id'],
            'attack_stat'  => ['bail','numeric', 'min:0', 'max:999'],
            'magic_stat'   => ['bail','numeric', 'min:0', 'max:999'],
            'defense_stat' => ['bail','numeric', 'min:0', 'max:999'],
            'support_stat' => ['bail','numeric', 'min:0', 'max:999'],
            'dodge_stat'   => ['bail','numeric', 'min:0', 'max:999'],
            'files.*'      => ['file', 'mimes:jpg,jpeg,png,svg,gif', 'max:5120'],
        ];

        $messages = [
            '*.required'                      => ':attribute không được để trống',
            'check_unique_card_name_update'   => 'Tên thẻ đã tồn tại',
            'check_exists_card_type'          => 'Loại thẻ không tồn tại',
            '*.numeric'                       => ':attribute phải là số',
            '*.min'                           => ':attribute không được nhỏ hơn :min',
            '*.max'                           => ':attribute không được lớn hơn :max',
            'mimes'                           => 'Chỉ được tải file có đuôi jpg, jpeg, png, svg, gif',
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

    // Advanced search method
    public function searchAdvanced(Request $request) {
        try {
            $query = Card::with([
                'cardType:card_type_id,card_type_name',
                'createUser:user_id,nickname',
                'updateUser:user_id,nickname'
            ]);

            // Multi-criteria search
            if ($request->has('keywords') && !empty($request->keywords)) {
                $keywords = $request->keywords;
                $query->where(function($q) use ($keywords) {
                    $q->where('card_name', 'like', "%{$keywords}%")
                      ->orWhere('card_code', 'like', "%{$keywords}%")
                      ->orWhere('description', 'like', "%{$keywords}%");
                });
            }

            // Filter by multiple card types
            if ($request->has('card_types') && is_array($request->card_types)) {
                $cardTypeIds = [];
                foreach ($request->card_types as $encryptedId) {
                    $cardTypeIds[] = _decrypt($encryptedId, CardType::KEY_CRYPT);
                }
                $query->whereIn('card_type_id', $cardTypeIds);
            }

            // Stat range filters
            $statFilters = ['attack_stat', 'defense_stat', 'magic_stat', 'support_stat', 'dodge_stat'];
            foreach ($statFilters as $stat) {
                if ($request->has($stat . '_range') && is_array($request->get($stat . '_range'))) {
                    $range = $request->get($stat . '_range');
                    if (isset($range['min']) && is_numeric($range['min'])) {
                        $query->where($stat, '>=', $range['min']);
                    }
                    if (isset($range['max']) && is_numeric($range['max'])) {
                        $query->where($stat, '<=', $range['max']);
                    }
                }
            }

            // Date range filter
            if ($request->has('date_range') && is_array($request->date_range)) {
                $dateRange = $request->date_range;
                if (isset($dateRange['start']) && !empty($dateRange['start'])) {
                    $query->where('create_date', '>=', $dateRange['start']);
                }
                if (isset($dateRange['end']) && !empty($dateRange['end'])) {
                    $query->where('create_date', '<=', $dateRange['end']);
                }
            }

            // Sorting
            $sortBy = $request->get('sort_by', 'card_name');
            $sortOrder = $request->get('sort_order', 'asc');
            $query->orderBy($sortBy, $sortOrder);

            // Pagination
            $perPage = $request->get('per_page', 20);
            $cards = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'code' => 200,
                'data' => CardResource::collection($cards->items()),
                'pagination' => [
                    'current_page' => $cards->currentPage(),
                    'total_pages' => $cards->lastPage(),
                    'total_items' => $cards->total(),
                    'per_page' => $cards->perPage(),
                ],
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => 500,
                'messages' => 'Lỗi! Vui lòng liên hệ admin',
                'error' => $th->getMessage()
            ]);
        }
    }
    public function show($id) {
        try {
            $cardId = is_numeric($id) ? $id : _decrypt($id, Card::KEY_CRYPT);
            
            $card = Card::with([
                'cardType:card_type_id,card_type_name',
                'createUser:user_id,nickname',
                'updateUser:user_id,nickname'
            ])->find($cardId);

            if (!$card) {
                return response()->json([
                    'success' => false,
                    'code' => 404,
                    'messages' => 'Không tìm thấy thẻ bài',
                ]);
            }

            return response()->json([
                'success' => true,
                'code' => 200,
                'data' => new CardResource($card),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => 500,
                'messages' => 'Lỗi! Vui lòng liên hệ admin',
            ]);
        }
    }

    public function create (Request $request) {
        
        $data    = [
            'card_name'    => $request->card_name,
            'card_type_id' => $request->card_type_id,
            'description'  => $request->description,
            'attack_stat'  => $request->attack_stat ?? 0,
            'magic_stat'   => $request->magic_stat ?? 0,
            'defense_stat' => $request->defense_stat ?? 0,
            'support_stat' => $request->support_stat ?? 0,
            'dodge_stat'   => $request->dodge_stat ?? 0,
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
                    DB::rollBack();
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
            CardHistory::create($dataHistory);

            DB::commit();
            return response()->json([
                'success'  => true,
                'code'     => 200,
                'messages' => 'Thêm mới dữ liệu thành công',
                'data'     => new CardResource($card),
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success'  => false,
                'code'     => 500,
                'messages' => 'Lỗi! Vui lòng liên hệ admin',
                'error'    => $th->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id) {
        try {
            $cardId = is_numeric($id) ? $id : _decrypt($id, Card::KEY_CRYPT);
            
            $card = Card::find($cardId);
            if (!$card) {
                return response()->json([
                    'success' => false,
                    'code' => 404,
                    'messages' => 'Không tìm thấy thẻ bài',
                ]);
            }

            $data = [
                'card_name'    => $request->card_name ?? $card->card_name,
                'card_type_id' => $request->card_type_id ?? $card->card_type_id,
                'description'  => $request->description ?? $card->description,
                'attack_stat'  => $request->attack_stat ?? $card->attack_stat,
                'magic_stat'   => $request->magic_stat ?? $card->magic_stat,
                'defense_stat' => $request->defense_stat ?? $card->defense_stat,
                'support_stat' => $request->support_stat ?? $card->support_stat,
                'dodge_stat'   => $request->dodge_stat ?? $card->dodge_stat,
                'files'        => $request->file('files'),
            ];

            // Validate for update (exclude current card from unique check)
            $validator = $this->_validateDataForUpdate($data, $cardId);
            if (!$validator['status']) {
                return response()->json([
                    'success'  => false,
                    'code'     => 400,
                    'messages' => 'Dữ liệu không hợp lệ',
                    'errors'   => $validator['errors'],
                ]);
            }

            DB::beginTransaction();
            
            $user = user();
            $user_id = $user->user_id;
            
            $files = $data['files'];
            unset($data['files']);

            if ($request->has('card_type_id') && !empty($request->card_type_id)) {
                $data['card_type_id'] = _decrypt($data['card_type_id'], CardType::KEY_CRYPT);
            }

            $data += [
                'update_user_id' => $user_id,
                'update_date' => date('Y-m-d H:i:s'),
            ];

            // Create history before update
            $currentVersion = CardHistory::where('ref_card_id', $cardId)->max('version') ?? 0;
            $dataHistory = $card->toArray();
            $dataHistory += [
                'version' => $currentVersion + 1,
                'ref_card_id' => $card->card_id,
            ];
            unset($dataHistory['card_id']);
            CardHistory::create($dataHistory);

            // Update card
            $card->update($data);

            // Handle file upload
            if ($files) {
                $checkUpload = UploadModel::uploadMultiFile(Card::FOLDER_FILE, $files, 1, Card::CONTROLLER_NAME, $card->card_id, $user_id);
                if (!$checkUpload) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'code' => 500,
                        'messages' => 'Không thể lưu file! Vui lòng thử lại sau',
                    ]);
                }
            }

            DB::commit();

            $updatedCard = Card::with(['cardType', 'createUser', 'updateUser'])->find($cardId);
            
            return response()->json([
                'success' => true,
                'code' => 200,
                'messages' => 'Cập nhật dữ liệu thành công',
                'data' => new CardResource($updatedCard),
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'code' => 500,
                'messages' => 'Lỗi! Vui lòng liên hệ admin',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function destroy($id) {
        try {
            $cardId = is_numeric($id) ? $id : _decrypt($id, Card::KEY_CRYPT);
            
            $card = Card::find($cardId);
            if (!$card) {
                return response()->json([
                    'success' => false,
                    'code' => 404,
                    'messages' => 'Không tìm thấy thẻ bài',
                ]);
            }

            DB::beginTransaction();

            // Create final history record before deletion
            $user = user();
            $currentVersion = CardHistory::where('ref_card_id', $cardId)->max('version') ?? 0;
            $dataHistory = $card->toArray();
            $dataHistory += [
                'version' => $currentVersion + 1,
                'ref_card_id' => $card->card_id,
            ];
            unset($dataHistory['card_id']);
            CardHistory::create($dataHistory);

            // Delete associated files (if any)
            // You might want to implement file deletion logic here

            // Delete the card
            $card->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'code' => 200,
                'messages' => 'Xóa thẻ bài thành công',
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'code' => 500,
                'messages' => 'Lỗi! Vui lòng liên hệ admin',
                'error' => $th->getMessage()
            ]);
        }
    }

    
}
