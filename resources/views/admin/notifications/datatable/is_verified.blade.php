    <span @class(['badge', App\Enums\VerifiedStatus::from($is_verified)->badge()])>
        {{ \App\Enums\VerifiedStatus::getDescription($is_verified) }}</span>


