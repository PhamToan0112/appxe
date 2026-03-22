<style>
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .dropdown-animate {
        animation: slideDown 0.5s ease forwards;
    }
</style>
<a {{ $attributes->class([
    'dropdown-toggle' => $dropdown,
    'dropdown-animate' => true
]) }}
   @if ($dropdown) data-bs-toggle="dropdown"
   data-bs-auto-close="false"
   role="button"
   aria-expanded="false" @endif>
    {{ $slot }}
</a>
<script>
    document.querySelector('.dropdown-toggle').addEventListener('click', function() {
        this.classList.add('dropdown-animate');
    });
</script>

