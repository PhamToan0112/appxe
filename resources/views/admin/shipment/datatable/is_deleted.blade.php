<span @class(['badge', App\Enums\DeleteStatus::from($is_deleted)->badge()])>{{ \App\Enums\DeleteStatus::getDescription($is_deleted) }}</span>
