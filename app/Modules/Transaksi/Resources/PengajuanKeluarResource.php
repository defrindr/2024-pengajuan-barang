<?php

namespace App\Modules\Transaksi\Resources;

use App\Models\Transaksi\PengajuanKeluarItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PengajuanKeluarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $parent = parent::toArray($request);
        $parent['items'] = PengajuanKeluarItem::where('transaksi_keluar_id', $this->id)->get();

        return $parent;
    }
}
