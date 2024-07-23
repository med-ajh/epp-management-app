<?php
namespace App\Filament\Resources\InventoryResource\Pages;

use App\Filament\Resources\InventoryResource;
use Filament\Resources\Pages\ViewRecord;
use App\Models\Inventory;

class ViewInventory extends ViewRecord
{
    protected static string $resource = InventoryResource::class;
}
