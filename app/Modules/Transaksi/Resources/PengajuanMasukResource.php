<?php

namespace App\Modules\Transaksi\Resources;

use App\Models\Transaksi\PengajuanMasukItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PengajuanMasukResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $parent = parent::toArray($request);
        $parent['items'] = PengajuanMasukItem::where('transaksi_masuk_id', $this->id)->get();

        return $parent;
    }
}
