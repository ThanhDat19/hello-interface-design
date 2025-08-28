# API Documentation - Card Game System

## Authentication
Tất cả các API (trừ public APIs) yêu cầu JWT token trong header:
```
Authorization: Bearer {token}
```

## Card APIs

### 1. Lấy danh sách thẻ (DataTable)
**GET** `/api/card/getData`

**Parameters:**
- `length` (int): Số lượng bản ghi mỗi trang (default: 20)
- `start` (int): Vị trí bắt đầu (default: 0)
- `search[value]` (string): Từ khóa tìm kiếm
- `card_name` (string): Lọc theo tên thẻ
- `card_type_id` (string): Lọc theo loại thẻ (encrypted ID)
- `attack_min/attack_max` (int): Lọc theo điểm tấn công
- `defense_min/defense_max` (int): Lọc theo điểm phòng thủ
- `magic_min/magic_max` (int): Lọc theo điểm phép
- `support_min/support_max` (int): Lọc theo điểm hỗ trợ
- `dodge_min/dodge_max` (int): Lọc theo điểm né
- `order_by` (string): Sắp xếp theo trường (card_name, attack_stat, etc.)
- `order_dir` (string): Hướng sắp xếp (asc/desc)

**Response:**
```json
{
    "recordsTotal": 100,
    "recordsFiltered": 50,
    "data": [...],
    "total": 50
}
```

### 2. Tìm kiếm nâng cao
**GET** `/api/card/search-advanced`

**Parameters:**
- `keywords` (string): Từ khóa tìm kiếm trong tên, mã, mô tả
- `card_types[]` (array): Mảng các loại thẻ (encrypted IDs)
- `attack_stat_range[min/max]` (int): Khoảng điểm tấn công
- `defense_stat_range[min/max]` (int): Khoảng điểm phòng thủ
- `magic_stat_range[min/max]` (int): Khoảng điểm phép
- `support_stat_range[min/max]` (int): Khoảng điểm hỗ trợ
- `dodge_stat_range[min/max]` (int): Khoảng điểm né
- `date_range[start/end]` (date): Khoảng thời gian tạo
- `sort_by` (string): Sắp xếp theo trường
- `sort_order` (string): Hướng sắp xếp (asc/desc)
- `per_page` (int): Số lượng bản ghi mỗi trang

**Example Request:**
```json
{
    "keywords": "dragon",
    "card_types": ["encrypted_id_1", "encrypted_id_2"],
    "attack_stat_range": {"min": 50, "max": 100},
    "defense_stat_range": {"min": 30, "max": 80},
    "sort_by": "attack_stat",
    "sort_order": "desc",
    "per_page": 20
}
```

### 3. Lấy thông tin một thẻ
**GET** `/api/card/{id}`

**Response:**
```json
{
    "success": true,
    "code": 200,
    "data": {
        "card_id": 1,
        "card_code": "CARD001",
        "card_name": "Fire Dragon",
        "card_type": {...},
        "description": "...",
        "attack_stat": 85,
        "defense_stat": 60,
        "magic_stat": 90,
        "support_stat": 30,
        "dodge_stat": 45
    }
}
```

### 4. Tạo thẻ mới
**POST** `/api/card/create`

**Parameters:**
- `card_name` (string, required): Tên thẻ
- `card_type_id` (string, required): ID loại thẻ (encrypted)
- `description` (string, optional): Mô tả
- `attack_stat` (int, 0-999): Điểm tấn công
- `defense_stat` (int, 0-999): Điểm phòng thủ  
- `magic_stat` (int, 0-999): Điểm phép
- `support_stat` (int, 0-999): Điểm hỗ trợ
- `dodge_stat` (int, 0-999): Điểm né
- `files[]` (files): Hình ảnh thẻ

### 5. Cập nhật thẻ
**PUT** `/api/card/{id}`

Parameters giống như tạo thẻ mới, nhưng tất cả đều optional.

### 6. Xóa thẻ
**DELETE** `/api/card/{id}`

## Card Type APIs

### 1. Lấy danh sách loại thẻ
**GET** `/api/card-type/getData`

**Parameters:**
- `length` (int): Số lượng bản ghi mỗi trang
- `start` (int): Vị trí bắt đầu
- `search[value]` (string): Từ khóa tìm kiếm
- `is_hero` (int): Lọc theo loại (1: hero, 2: normal)
- `order_by/order_dir`: Sắp xếp

### 2. Lấy thông tin một loại thẻ
**GET** `/api/card-type/{id}`

### 3. Tạo loại thẻ mới
**POST** `/api/card-type/`

**Parameters:**
- `card_type_name` (string, required): Tên loại thẻ
- `description` (string, optional): Mô tả
- `is_hero` (int, required): Loại thẻ (1: hero, 2: normal)

### 4. Cập nhật loại thẻ
**PUT** `/api/card-type/{id}`

### 5. Xóa loại thẻ
**DELETE** `/api/card-type/{id}`

## Public APIs (Không cần authentication)

### 1. Lấy danh sách loại thẻ công khai
**GET** `/api/public/card-types`

### 2. Tìm kiếm thẻ công khai
**GET** `/api/public/cards/search`

## Error Responses

```json
{
    "success": false,
    "code": 400,
    "messages": "Dữ liệu không hợp lệ",
    "errors": {
        "card_name": ["Tên thẻ không được để trống"]
    }
}
```

## Status Codes
- 200: Thành công
- 400: Dữ liệu không hợp lệ
- 404: Không tìm thấy
- 500: Lỗi server