@extends('admin.layouts.admin-master')

@section('title', 'Application Review — ' . $application->application_no)

@section('content')
    <div class="heading">
        <div>
            <small>SCREENING & INTERVIEW PIPELINE</small>
            <h1>{{ $application->student_name }}</h1>
            <p>
                Application <strong>{{ $application->application_no }}</strong> for
                <strong>{{ $application->course?->title ?? 'Deleted Course' }}</strong>
                @if ($application->course?->batch_no)
                    ({{ $application->course->batch_no }})
                @endif
            </p>
        </div>
        <div class="d-flex gap-2">
            @if ($application->learner)
                <a href="{{ route('admin.learners.show', $application->learner) }}" class="btn primary">
                    <i class="bi bi-person-badge me-1"></i> View Learner ({{ $application->learner->learner_code }})
                </a>
            @elseif (auth()->user()?->can('edit-course-applications'))
                <form action="{{ route('admin.course-applications.enroll', $application) }}" method="POST"
                    onsubmit="return confirm('Convert this applicant into a Learner and enroll them into this course?');">
                    @csrf
                    <button type="submit" class="btn primary">
                        <i class="bi bi-person-plus me-1"></i> Enroll as Learner
                    </button>
                </form>
            @endif
            <a href="{{ route('admin.course-applications.index') }}" class="btn light">
                <i class="bi bi-arrow-left me-1"></i> Back to Applications
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert-custom alert-custom-success mb-3">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert-custom alert-custom-danger mb-3">
            <div>
                <strong>Please resolve the following issues:</strong>
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="row">
        {{-- Left Column: Applicant Profile & Screening Details --}}
        <div class="col-lg-7">
            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Applicant Profile & Background</h5>
                    <span class="{{ $application->status->badgeClass() }}">
                        <i class="bi {{ $application->status->icon() }} me-1"></i>
                        {{ $application->status->label() }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="text-muted small">Full Name</div>
                            <div class="fw-semibold">{{ $application->student_name }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted small">Email Address</div>
                            <div class="fw-semibold">{{ $application->email }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted small">Phone Number</div>
                            <div class="fw-semibold">{{ $application->phone }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted small">Alternative Phone</div>
                            <div class="fw-semibold">{{ $application->alt_phone ?: '—' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted small">Educational Qualification</div>
                            <div class="fw-semibold">{{ $application->educational_qualification ?: '—' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted small">Current Profession / Institute</div>
                            <div class="fw-semibold">{{ $application->current_profession ?: '—' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted small">Experience Level</div>
                            <div class="fw-semibold">{{ $application->experience_level ?: '—' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-muted small">Portfolio / GitHub</div>
                            <div>
                                @if ($application->portfolio_or_github)
                                    <a href="{{ $application->portfolio_or_github }}" target="_blank" class="text-primary text-decoration-none">
                                        {{ $application->portfolio_or_github }} <i class="bi bi-box-arrow-up-right small"></i>
                                    </a>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="text-muted small">Present Address</div>
                            <div>{{ $application->present_address ?: '—' }}</div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div>
                        <h6 class="fw-bold mb-2">Why does the applicant want to join this course? (Screening Answer)</h6>
                        <div class="p-3 bg-light rounded border">
                            {{ $application->why_this_course ?: 'No motivation statement provided.' }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Fee & Payment Summary --}}
            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Fee & Payment Details</h5>
                    <span class="{{ $application->payment_status->badgeClass() }}">{{ $application->payment_status->label() }}</span>
                </div>
                <div class="card-body">
                    @php
                        $symbol = $application->currency?->symbol ?? $defaultCurrency?->symbol ?? '৳';
                    @endphp
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="text-muted small">Course Fee</div>
                            <div class="fw-semibold">{{ $symbol }}{{ number_format($application->course_fee, 2) }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-muted small">Coupon Discount</div>
                            <div class="fw-semibold text-success">
                                -{{ $symbol }}{{ number_format($application->discount_amount, 2) }}
                                @if ($application->coupon)
                                    <span class="badge bg-light text-dark border ms-1">{{ $application->coupon->code }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-muted small">Payable Amount</div>
                            <div class="fw-bold text-primary">{{ $symbol }}{{ number_format($application->payable_amount, 2) }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-muted small">Payment Method</div>
                            <div class="fw-semibold text-uppercase">{{ $application->payment_method }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-muted small">Transaction ID (TrxID)</div>
                            <div>
                                @if ($application->transaction_id)
                                    <code>{{ $application->transaction_id }}</code>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-muted small">Sender Number</div>
                            <div>{{ $application->sender_phone_number ?: '—' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Screening, Interview & Selection Form --}}
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Screening, Interview & Selection</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.course-applications.update', $application) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold" for="status">Application Stage <span class="text-danger">*</span></label>
                            <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                                @foreach ($statuses as $st)
                                    <option value="{{ $st->value }}" {{ old('status', $application->status->value) === $st->value ? 'selected' : '' }}>
                                        {{ $st->label() }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold" for="payment_status">Payment Status <span class="text-danger">*</span></label>
                            <select id="payment_status" name="payment_status" class="form-select @error('payment_status') is-invalid @enderror" required>
                                @foreach ($paymentStatuses as $ps)
                                    <option value="{{ $ps->value }}" {{ old('payment_status', $application->payment_status->value) === $ps->value ? 'selected' : '' }}>
                                        {{ $ps->label() }}
                                    </option>
                                @endforeach
                            </select>
                            @error('payment_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-3">
                        <h6 class="fw-bold mb-3 text-primary"><i class="bi bi-calendar-event me-1"></i> Interview Schedule</h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="interview_date">Interview Date</label>
                                <input type="date" id="interview_date" name="interview_date"
                                    class="form-control @error('interview_date') is-invalid @enderror"
                                    value="{{ old('interview_date', $application->interview_date?->format('Y-m-d')) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="interview_time">Interview Time</label>
                                <input type="time" id="interview_time" name="interview_time"
                                    class="form-control @error('interview_time') is-invalid @enderror"
                                    value="{{ old('interview_time', $application->interview_time) }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="interview_venue">Interview Venue / Meeting Link</label>
                            <input type="text" id="interview_venue" name="interview_venue"
                                class="form-control @error('interview_venue') is-invalid @enderror"
                                value="{{ old('interview_venue', $application->interview_venue ?? $application->course?->venue) }}"
                                placeholder="Office Room or Google Meet link">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="interview_notes">Interview Feedback / Evaluation Notes</label>
                            <textarea id="interview_notes" name="interview_notes" rows="3"
                                class="form-control @error('interview_notes') is-invalid @enderror"
                                placeholder="Record interview score, communication skills, technical baseline...">{{ old('interview_notes', $application->interview_notes) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="admin_notes">Internal Admin Notes</label>
                            <textarea id="admin_notes" name="admin_notes" rows="2"
                                class="form-control @error('admin_notes') is-invalid @enderror"
                                placeholder="Any internal notes for team members...">{{ old('admin_notes', $application->admin_notes) }}</textarea>
                        </div>

                        @can('edit-course-applications')
                            <button type="submit" class="btn primary w-100">
                                <i class="bi bi-check-lg me-1"></i> Save Screening & Interview Update
                            </button>
                        @endcan
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
