<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CardTypeResource;
use App\Models\Card;
use App\Models\CardType;
use App\Models\CardTypeHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CardTypeAPIController extends Controller
{
    public function getDataHandle(Request $request) {
        $limit = $request->get('length', 20);
        $start = $request->get('start', 0);

        $query = CardType::select(
            'card_type_id',
            'card_type_name',
            'description',
            'is_hero',
            'create_user_id',
            'create_date',
            'update_user_id',
            'update_date'
        )->with([
            'createUser:user_id,nickname',
            'updateUser:user_id,nickname'
        ]);

        // Search functionality
        if ($request->has('search') && !empty($request->search['value'])) {
            $searchTerm = $request->search['value'];
            $query->where(function($q) use ($searchTerm) {
                $q->where('card_type_name', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by hero type
        if ($request->has('is_hero') && $request->is_hero !== '') {
            $query->where('is_hero', $request->is_hero);
        }

        // Sorting
        $orderBy = $request->get('order_by', 'card_type_name');
        $orderDir = $request->get('order_dir', 'asc');
        $allowedOrderBy = ['card_type_name', 'is_hero', 'create_date'];
        
        if (in_array($orderBy, $allowedOrderBy)) {
            $query->orderBy($orderBy, $orderDir);
        } else {
            $query->orderBy('card_type_name', 'asc');
        }

        $countTotal = (clone $query)->count();
        
        if ($request->has('length')) {
            $data = $query->limit($limit)->offset($start)->get();
        } else {
            $data = $query->get();
        }

        $data = CardTypeResource::collection($data);
        
        return response()->json([
            'success' => true,
            'code' => 200,
            'data' => $data,
            'recordsTotal' => $countTotal,
            'recordsFiltered' => $countTotal,
        ]);
    }

    public function show($id) {
        try {
            $cardTypeId = is_numeric($id) ? $id : _decrypt($id, CardType::KEY_CRYPT);
            
            $cardType = CardType::with([
                'createUser:user_id,nickname',
                'updateUser:user_id,nickname'
            ])->find($cardTypeId);

            if (!$cardType) {
                return response()->json([
                    'success' => false,
                    'code' => 404,
                    'messages' => 'Không tìm thấy loại thẻ',
                ]);
            }

            return response()->json([
                'success' => true,
                'code' => 200,
                'data' => new CardTypeResource($cardType),
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'code' => 500,
                'messages' => 'Lỗi! Vui lòng liên hệ admin',
            ]);
        }
    }

    public function create(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'card_type_name' => 'required|unique:tbl_card_type,card_type_name',
                'description' => 'nullable|string',
                'is_hero' => 'required|in:1,2'
            ], [
                'card_type_name.required' => 'Tên loại thẻ không được để trống',
                'card_type_name.unique' => 'Tên loại thẻ đã tồn tại',
                'is_hero.required' => 'Vui lòng chọn loại thẻ',
                'is_hero.in' => 'Loại thẻ không hợp lệ',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'code' => 400,
                    'messages' => 'Dữ liệu không hợp lệ',
                    'errors' => $validator->errors()->toArray(),
                ]);
            }

            DB::beginTransaction();

            $user = user();
            $data = [
                'card_type_name' => $request->card_type_name,
                'description' => $request->description,
                'is_hero' => $request->is_hero,
                'create_user_id' => $user->user_id,
                'create_date' => date('Y-m-d H:i:s'),
            ];

            $cardType = CardType::create($data);

            // Create history
            $dataHistory = $cardType->toArray();
            $dataHistory += [
                'version' => 1,
                'ref_card_type_id' => $cardType->card_type_id,
            ];
            unset($dataHistory['card_type_id']);
            CardTypeHistory::create($dataHistory);

            DB::commit();

            return response()->json([
                'success' => true,
                'code' => 200,
                'messages' => 'Thêm mới loại thẻ thành công',
                'data' => new CardTypeResource($cardType),
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

    public function update(Request $request, $id) {
        try {
            $cardTypeId = is_numeric($id) ? $id : _decrypt($id, CardType::KEY_CRYPT);
            
            $cardType = CardType::find($cardTypeId);
            if (!$cardType) {
                return response()->json([
                    'success' => false,
                    'code' => 404,
                    'messages' => 'Không tìm thấy loại thẻ',
                ]);
            }

            $validator = Validator::make($request->all(), [
                'card_type_name' => 'required|unique:tbl_card_type,card_type_name,' . $cardTypeId . ',card_type_id',
                'description' => 'nullable|string',
                'is_hero' => 'required|in:1,2'
            ], [
                'card_type_name.required' => 'Tên loại thẻ không được để trống',
                'card_type_name.unique' => 'Tên loại thẻ đã tồn tại',
                'is_hero.required' => 'Vui lòng chọn loại thẻ',
                'is_hero.in' => 'Loại thẻ không hợp lệ',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'code' => 400,
                    'messages' => 'Dữ liệu không hợp lệ',
                    'errors' => $validator->errors()->toArray(),
                ]);
            }

            DB::beginTransaction();

            $user = user();

            // Create history before update
            $currentVersion = CardTypeHistory::where('ref_card_type_id', $cardTypeId)->max('version') ?? 0;
            $dataHistory = $cardType->toArray();
            $dataHistory += [
                'version' => $currentVersion + 1,
                'ref_card_type_id' => $cardType->card_type_id,
            ];
            unset($dataHistory['card_type_id']);
            CardTypeHistory::create($dataHistory);

            // Update card type
            $updateData = [
                'card_type_name' => $request->card_type_name,
                'description' => $request->description,
                'is_hero' => $request->is_hero,
                'update_user_id' => $user->user_id,
                'update_date' => date('Y-m-d H:i:s'),
            ];

            $cardType->update($updateData);

            DB::commit();

            $updatedCardType = CardType::with(['createUser', 'updateUser'])->find($cardTypeId);

            return response()->json([
                'success' => true,
                'code' => 200,
                'messages' => 'Cập nhật loại thẻ thành công',
                'data' => new CardTypeResource($updatedCardType),
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
            $cardTypeId = is_numeric($id) ? $id : _decrypt($id, CardType::KEY_CRYPT);
            
            $cardType = CardType::find($cardTypeId);
            if (!$cardType) {
                return response()->json([
                    'success' => false,
                    'code' => 404,
                    'messages' => 'Không tìm thấy loại thẻ',
                ]);
            }

            // Check if card type is being used by any cards
            $cardCount = Card::where('card_type_id', $cardTypeId)->count();
            if ($cardCount > 0) {
                return response()->json([
                    'success' => false,
                    'code' => 400,
                    'messages' => 'Không thể xóa loại thẻ này vì đang được sử dụng bởi ' . $cardCount . ' thẻ bài',
                ]);
            }

            DB::beginTransaction();

            // Create final history record before deletion
            $user = user();
            $currentVersion = CardTypeHistory::where('ref_card_type_id', $cardTypeId)->max('version') ?? 0;
            $dataHistory = $cardType->toArray();
            $dataHistory += [
                'version' => $currentVersion + 1,
                'ref_card_type_id' => $cardType->card_type_id,
            ];
            unset($dataHistory['card_type_id']);
            CardTypeHistory::create($dataHistory);

            // Delete the card type
            $cardType->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'code' => 200,
                'messages' => 'Xóa loại thẻ thành công',
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
