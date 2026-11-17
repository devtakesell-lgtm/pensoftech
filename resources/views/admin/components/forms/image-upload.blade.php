@props([
    'label',
    'name',
    'preview' => null,
    'current' => null,
    'help' => 'PNG, JPG or WEBP up to 2MB.',
    'aspect' => 'square',
    'required' => false,
])

@php
    $hasError = $errors->has($name);
    // Use max-width to prevent the box from stretching too wide, maintaining the aspect ratio.
    $aspectStyle = match ($aspect) {
        'wide' => 'aspect-ratio: 16/7; width: 100%; max-width: 100%;',
        'banner' => 'aspect-ratio: 21/9; width: 100%; max-width: 100%;',
        'video' => 'aspect-ratio: 16/9; width: 100%; max-width: 600px;',
        'portrait' => 'aspect-ratio: 3/4; width: 100%; max-width: 250px;',
        'square' => 'aspect-ratio: 1/1; width: 100%; max-width: 250px;',
        'landscape' => 'aspect-ratio: 4/3; width: 100%; max-width: 350px;',
        default => 'aspect-ratio: 1/1; width: 100%; max-width: 250px;',
    };
@endphp

<div class="mb-3">
    <label for="{{ $name }}" class="form-label fw-semibold">
        {{ $label }} @if ($required)
            <span class="text-danger">*</span>
        @endif
    </label>

    <div x-data="{
        previewUrl: @js($current ?? $preview),
        fileName: null,
        fileSize: null,
        isDragging: false,
        handleFile(file) {
            if (!file || !file.type.startsWith('image/')) return;
            this.fileName = file.name;
            this.fileSize = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
            const reader = new FileReader();
            reader.onload = (e) => { this.previewUrl = e.target.result; };
            reader.readAsDataURL(file);
        },
        onFileSelect(event) {
            const file = event.target.files[0];
            this.handleFile(file);
        },
        onDrop(event) {
            this.isDragging = false;
            const file = event.dataTransfer.files[0];
            if (file) {
                const input = this.$refs.fileInput;
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                input.files = dataTransfer.files;
                this.handleFile(file);
            }
        }
    }" @dragover.prevent="isDragging = true" @dragleave.prevent="isDragging = false"
        @drop.prevent="onDrop($event)"
        :class="isDragging ? 'border-primary bg-light' :
            '{{ $hasError ? 'border-danger bg-danger-subtle' : 'border-secondary bg-white' }}'"
        class="position-relative overflow-hidden rounded-3 border border-2 border-dashed transition-all"
        style="transition: all 0.2s ease; {{ $aspectStyle }} background-color: #f8f9fa;">
        <div class="position-relative w-100 h-100 d-flex align-items-center justify-content-center">

            {{-- Preview / current image --}}
            <div x-show="previewUrl" class="position-absolute top-0 start-0 w-100 h-100">
                <img :src="previewUrl" alt="Preview" class="w-100 h-100 object-fit-cover">
            </div>

            {{-- Placeholder when no image --}}
            <div :class="!previewUrl ? 'd-flex' : 'd-none'"
                class="position-absolute top-0 start-0 w-100 h-100 flex-column align-items-center justify-content-center text-center p-4">
                <div class="d-flex align-items-center justify-content-center rounded-circle bg-light text-primary mb-2"
                    style="width: 50px; height: 50px;">
                    <i class="bi bi-cloud-arrow-up fs-4"></i>
                </div>
                <div>
                    <p class="mb-0 fw-medium text-dark">Click to upload image</p>
                    <p class="mt-1 small text-muted">or drag and drop file here</p>
                </div>
            </div>

            {{-- Hover overlay change badge --}}
            <div x-show="previewUrl" x-cloak
                class="position-absolute bottom-0 start-0 w-100 px-3 pb-3 pt-5 text-center pointer-events-none"
                style="background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 100%);">
                <span class="badge bg-light text-dark shadow-sm px-3 py-2 rounded-pill border">
                    <i class="bi bi-camera me-1"></i> <span
                        x-text="fileName ? 'Change selected image' : 'Change image'"></span>
                </span>
            </div>
        </div>

        <input x-ref="fileInput" type="file" name="{{ $name }}" id="{{ $name }}"
            accept="image/png,image/jpeg,image/webp,image/gif" @change="onFileSelect($event)"
            class="position-absolute top-0 start-0 w-100 h-100" style="opacity: 0; cursor: pointer; z-index: 10;"
            aria-label="{{ $label }}">
    </div>

    {{-- File selected banner --}}
    {{-- <div :class="fileName ? 'd-flex' : 'd-none'" x-cloak
        class="mt-2 align-items-center gap-2 rounded border border-success bg-success-subtle px-3 py-2 text-success"
        style="font-size: 0.85rem;">
        <i class="bi bi-check-circle-fill"></i>
        <span class="flex-grow-1 text-truncate fw-medium" x-text="fileName + ' (' + fileSize + ')'"></span>
        <span class="badge bg-success bg-opacity-25 text-success border border-success">Selected</span>
    </div> --}}

    @if ($hasError)
        <div class="text-danger small mt-1">
            <i class="bi bi-exclamation-circle me-1"></i> {{ $errors->first($name) }}
        </div>
    @elseif($help)
        <div class="form-text mt-1">
            <i class="bi bi-info-circle me-1"></i> {{ $help }}
        </div>
    @endif
</div>
