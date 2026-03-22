<span @class([
    'badge',
    \App\Enums\User\UserRoles::from($role)->badge(),
])>
    {{ \App\Enums\User\UserRoles::getDescription($role) }}
    @if($role === \App\Enums\User\UserRoles::Customer->value)
        (Chờ duyệt)
    @endif
</span>
