<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\CardHistory;
use App\Models\CardType;
use App\Models\CardTypeHistory;
use App\Models\NextCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();
        try {
            $users = [
                [
                    'fullname'       => 'Hân hồ admin',
                    'nickname'       => 'Hân hồ',
                    'email'          => 'hungho9286@gmail.com',
                    'password'       => Hash::make('123456'),
                    'username'       => 'hanho',
                    'phone'          => '0919356603',
                    'role'           => 1,
                    'create_user_id' => null,
                    'create_date'    => date('Y-m-d H:i:s'),
                    'update_user_id' => null,
                    'update_date'    => null,
                ],
                [
                    'fullname'       => 'Lính mới tập chơi',
                    'nickname'       => 'Lính tập chơi',
                    'email'          => 'tapchoi@gmail.com',
                    'password'       => Hash::make('123456'),
                    'username'       => 'tapchoi01',
                    'phone'          => '0919356604',
                    'role'           => 2,
                    'create_user_id' => null,
                    'create_date'    => date('Y-m-d H:i:s'),
                    'update_user_id' => null,
                    'update_date'    => null,
                ],
                [
                    'fullname'       => 'Kì cựu lâu năm',
                    'nickname'       => 'Dân pro',
                    'email'          => 'danpro@gmail.com',
                    'password'       => Hash::make('123456'),
                    'username'       => 'danpro01',
                    'phone'          => '0919356605',
                    'role'           => 2,
                    'create_user_id' => null,
                    'create_date'    => date('Y-m-d H:i:s'),
                    'update_user_id' => null,
                    'update_date'    => null,
                ],
                [
                    'fullname'       => 'Thích nạp vip',
                    'nickname'       => 'Thích nạp vip',
                    'email'          => 'thichnapvip@gmail.com',
                    'password'       => Hash::make('123456'),
                    'username'       => 'thichnapvip01',
                    'phone'          => '0919356606',
                    'role'           => 2,
                    'create_user_id' => null,
                    'create_date'    => date('Y-m-d H:i:s'),
                    'update_user_id' => null,
                    'update_date'    => null,
                ],
            ];
            foreach ($users as $key => $user) {
                $record = User::create($user);
                $user['ref_user_id'] = $record->user_id;
                $user['version']     = 1;
                UserHistory::create($user);
            }
            $cardTypes = [
                [
                    'card_type_name' => "Thẻ hero",
                    'description'    => "Thẻ hero, trên trận móc hero ra xài",
                    'is_hero'        => 1,
                    'create_user_id' => 1,
                    'create_date'    => date('Y-m-d H:i:s'),
                    'update_user_id' => null,
                    'update_date'    => null,

                ],
                [
                    'card_type_name' => "Thẻ hỗ trợ",
                    'description'    => "Thẻ hỗ trợ, thủ công, phép, hồi máu,...",
                    'is_hero'        => 2,
                    'create_user_id' => 1,
                    'create_date'    => date('Y-m-d H:i:s'),
                    'update_user_id' => null,
                    'update_date'    => null,

                ],
            ];
            foreach ($cardTypes as $key => $cardType) {
                $record = CardType::create($cardType);
                $cardType['ref_card_type_id'] = $record->card_type_id;
                $cardType['version']     = 1;
                CardTypeHistory::create($cardType);
            }
            $cards = [
                [
                    'card_type_id'   => 1,
                    'card_code'      => 'CARD0000001',
                    'card_name'      => 'Văn hào',
                    'description'    => 'Xạ thủ thích lên phép',
                    'defense_stat'   => 0,
                    'magic_stat'     => 1,
                    'support_stat'   => 0,
                    'attack_stat'    => 5,
                    'dodge_stat'     => 5,
                    'create_user_id' => 1,
                    'create_date'    => date('Y-m-d H:i:s'),
                    'update_user_id' => null,
                    'update_date'    => null,
                ],
                [
                    'card_type_id'   => 1,
                    'card_code'      => 'CARD0000002',
                    'card_name'      => 'Hayate',
                    'description'    => 'Tướng xàm cứ nhảy ulti là có mạng',
                    'defense_stat'   => 0,
                    'magic_stat'     => 0,
                    'support_stat'   => 0,
                    'attack_stat'    => 7,
                    'dodge_stat'     => 3,
                    'create_user_id' => 1,
                    'create_date'    => date('Y-m-d H:i:s'),
                    'update_user_id' => null,
                    'update_date'    => null,
                ],
                [
                    'card_type_id'   => 1,
                    'card_code'      => 'CARD0000003',
                    'card_name'      => 'Nakroth',
                    'description'    => 'Tướng sát thủ, nhưng bay dô giao tranh tự lăn ra chết =))))',
                    'defense_stat'   => 2,
                    'magic_stat'     => 0,
                    'support_stat'   => 3,
                    'attack_stat'    => 8,
                    'dodge_stat'     => 6,
                    'create_user_id' => 1,
                    'create_date'    => date('Y-m-d H:i:s'),
                    'update_user_id' => null,
                    'update_date'    => null,
                ],
                [
                    'card_type_id'   => 2,
                    'card_code'      => 'CARD0000004',
                    'card_name'      => 'Thẻ hồi máu',
                    'description'    => 'Buff được xí máu, không buff cũng được',
                    'defense_stat'   => 0,
                    'magic_stat'     => 0,
                    'support_stat'   => 0,
                    'attack_stat'    => 0,
                    'dodge_stat'     => 0,
                    'create_user_id' => 1,
                    'create_date'    => date('Y-m-d H:i:s'),
                    'update_user_id' => null,
                    'update_date'    => null,
                ],
                [
                    'card_type_id'   => 2,
                    'card_code'      => 'CARD0000005',
                    'card_name'      => 'Thẻ phòng thủ',
                    'description'    => 'Đỡ được mọi sát thương, nhưng Hayate nhảy dô ulti cũng tự chết',
                    'defense_stat'   => 0,
                    'magic_stat'     => 0,
                    'support_stat'   => 0,
                    'attack_stat'    => 0,
                    'dodge_stat'     => 0,
                    'create_user_id' => 1,
                    'create_date'    => date('Y-m-d H:i:s'),
                    'update_user_id' => null,
                    'update_date'    => null,
                ],
            ];
            foreach ($cards as $key => $card) {
                $record = Card::create($card);
                $card['ref_card_id'] = $record->card_id;
                $card['version']     = 1;
                CardHistory::create($card);
            }
            $next_codes = [
                [
                    'table_name' => 'tbl_card',
                    'increament' => 1,
                    'cur_value'  => 6,
                ]
            ];
            foreach ($next_codes as $key => $next_code) {
                NextCode::create($next_code);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }
    }
}
