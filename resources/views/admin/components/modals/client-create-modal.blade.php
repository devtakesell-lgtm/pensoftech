@props([
    'formAction' => '', // Default to empty string to avoid missing route exception
    'defaultContactPerson' => '',
    'defaultEmail' => '',
    'defaultCompanyName' => '',
    'defaultPhone' => '',
    'defaultWebsite' => '',
    'modalId' => 'clientCreateModal',
    'title' => 'Create Client Profile',
    'description' => 'This will create a new Client record and a linked User account. A random password will be generated and emailed to the client automatically.',
    'submitText' => 'Create Client Profile'
])

<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fs-4 fw-bold text-dark" id="{{ $modalId }}Label">
                    <i class="bi bi-person-check-fill text-primary me-2"></i> {{ $title }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ $formAction }}" method="POST">
                @csrf
                <div class="modal-body py-4">
                    <p class="text-muted mb-4">
                        {{ $description }}
                    </p>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="contact_person" class="form-label fw-semibold">Primary Contact Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="contact_person" name="contact_person" value="{{ old('contact_person', $defaultContactPerson) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">Email Address (Login ID) <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $defaultEmail) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="company_name" class="form-label fw-semibold">Company Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="company_name" name="company_name" value="{{ old('company_name', $defaultCompanyName) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-semibold">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $defaultPhone) }}">
                        </div>
                        <div class="col-12">
                            <label for="website" class="form-label fw-semibold">Website</label>
                            <!-- Changed to text to avoid HTML5 protocol validation forcing http:// -->
                            <input type="text" class="form-control" id="website" name="website" value="{{ old('website', $defaultWebsite) }}" placeholder="e.g. example.com or https://example.com">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn primary">
                        <i class="bi bi-check-lg me-1"></i> {{ $submitText }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
