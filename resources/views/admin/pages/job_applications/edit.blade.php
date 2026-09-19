@extends('admin.layouts.admin-master')

@section('title', 'Update Application Status')

@section('content')
    <div class="heading">
        <div class="d-flex align-items-center">
            <a href="{{ route('admin.job-applications.show', $jobApplication) }}" class="btn btn-outline-secondary btn-sm me-3">
                <i class="bi bi-arrow-left"></i> Back to Details
            </a>
            <div>
                <small>UPDATE STATUS</small>
                <h1>{{ $jobApplication->name }}</h1>
                <p>Update the hiring progress for this candidate.</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card p-4">
                <form action="{{ route('admin.job-applications.update', $jobApplication) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="status" class="form-label fw-bold">Application Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                            @foreach($statuses as $status)
                                <option value="{{ $status->value }}" {{ old('status', $jobApplication->status->value) === $status->value ? 'selected' : '' }}>
                                    {{ $status->label() }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch p-3 bg-light rounded border">
                            <input class="form-check-input ms-0 me-3" type="checkbox" role="switch" id="notify_candidate" name="notify_candidate" value="1" style="width: 2.5em; height: 1.25em;">
                            <label class="form-check-label pt-1" style="margin-left: 2.5rem;" for="notify_candidate">
                                <strong>Send Email Notification</strong>
                                <div class="text-muted small mt-1">
                                    If checked, an email will be sent to <code>{{ $jobApplication->email }}</code> notifying them of this status update.
                                </div>
                            </label>
                        </div>
                        @error('notify_candidate')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="notes" class="form-label fw-bold">Internal HR Notes</label>
                        <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="5" placeholder="Add any private notes about the interview, candidate impression, etc. (Visible only to admins)">{{ old('notes', $jobApplication->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">These notes will not be included in the email if you chose to notify the candidate.</div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.job-applications.show', $jobApplication) }}" class="btn btn-light">Cancel</a>
                        <button type="submit" class="btn primary">
                            <i class="bi bi-save me-1"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
