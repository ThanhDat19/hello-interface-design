<?php

namespace App\Http\Resources;

use App\Models\CardType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CardTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'card_type_id'   => _encrypt($this->card_type_id, CardType::KEY_CRYPT),
            'card_type_name' => $this->card_type_name,
            'description'    => $this->description,
        ];
    }
}
