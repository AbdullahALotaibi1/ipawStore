<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Redirect;

class ApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'app_id' => $this->id,
            'app_name' => $this->applicationsInfo->app_name,
            'app_icon' => 'storage/store/_icon/'.$this->applicationsInfo->app_icon,
            'app_bundle' => $this->applicationsInfo->app_bundle,
            'app_version' => $this->applicationsInfo->app_version,
            'app_size' => $this->applicationsInfo->app_size,
        ];
    }
}
