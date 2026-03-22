<span @class([
    'badge',
    App\Enums\Shipment\ShipmentStatus::from($shipment_status)->badge(),
])>{{ \App\Enums\Shipment\ShipmentStatus::getDescription($shipment_status) }}</span>
