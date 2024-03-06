<?php

namespace App\Modules\Inventaris\Resources;

use App\Models\Inventaris\Kategori;
use App\Models\Inventaris\Rak;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventarisResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $parent =  parent::toArray($request);

        $parent['qrcode'] = route('v1.master.inventaris.qr', ['id' => $this->id]);
        $parent['category'] = Kategori::where('id', $this->category_id)->first();
        $parent['rak'] = Rak::where('id', $this->rak_id)->first();

        return $parent;
    }
}
