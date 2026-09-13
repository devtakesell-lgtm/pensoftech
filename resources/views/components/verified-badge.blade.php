@props([
    'title' => 'Verified Client Account',
    'url' => null,
])

@if ($url)
    <a href="{{ $url }}" 
       class="verified-client-badge text-decoration-none" 
       title="{{ $title }}"
       data-bs-toggle="tooltip" 
       data-bs-placement="top"
       aria-label="{{ $title }}">
        <i class="bi bi-patch-check-fill"></i>
    </a>
@else
    <span class="verified-client-badge" 
          title="{{ $title }}"
          data-bs-toggle="tooltip" 
          data-bs-placement="top"
          aria-label="{{ $title }}">
        <i class="bi bi-patch-check-fill"></i>
    </span>
@endif
