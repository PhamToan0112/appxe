@if ($row)
    @php
        $user = \App\Models\User::find($row);
    @endphp

    <x-link :href="route('admin.user.edit', $row)" :title="$user->fullname" />
@else
    <span class="text-muted">{{ __('N/A') }}</span>
@endif
