<?php

namespace App\Http\Resources;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'card_code' => $this->card_code,
            'card_id'   => _encrypt($this->card_id, Card::KEY_CRYPT),
            'card_name' => $this->card_name,
            'card_type' => ($this->cardType ? [
                'name' => $this->cardType?->card_type_name,
            ] : null),
            'description'  => $this->description,
            'defense_stat' => $this->defense_stat,
            'magic_stat'   => $this->magic_stat,
            'attack_stat'  => $this->attack_stat,
            'dodge_stat'   => $this->dodge_stat,
            'create_user'  => ($this->createUser ? [
                'nickname' => $this->createUser?->nickname,
            ] : null),
            'create_date' => $this->create_date,
            'update_user' => ($this->updateUser ? [
                'nickname' => $this->updateUser?->nickname,
            ] : null),
            'update_date' => $this->update_date
        ];
    }
}
