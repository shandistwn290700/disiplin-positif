@props(['icon' => 'inbox'])

<div class="empty-state">
    <x-icon :name="$icon" />
    <span>{{ $slot }}</span>
</div>
