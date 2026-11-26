@extends('frontend.layouts.front-master')

@section('title', 'Apply for ' . $course->title . ' — PenSoftTech Academy')

@section('content')
    @php
        $symbol = $course->currency?->symbol ?? $defaultCurrency?->symbol ?? '৳';
        $effectivePrice = $course->effectivePrice();
    @endphp

    <main>
        {{-- 1. HERO HEADER (DARK) --}}
        <section class="bg-black text-gray-100 pt-36 md:pt-44 pb-12 relative overflow-hidden">
            <div class="absolute top-1/4 -right-48 w-96 h-96 bg-[#4fd1c5]/10 rounded-full blur-[140px] pointer-events-none"></div>

            <div class="max-w-6xl mx-auto px-5 lg:px-12 relative z-10">
                <nav class="flex items-center gap-2 text-xs font-semibold text-gray-400 mb-5 uppercase tracking-wider" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                    <span>/</span>
                    <a href="{{ route('courses.index') }}" class="hover:text-white transition-colors">Courses</a>
                    <span>/</span>
                    <a href="{{ route('courses.show', $course->slug) }}" class="hover:text-white transition-colors truncate max-w-[150px] sm:max-w-xs">{{ $course->title }}</a>
                    <span>/</span>
                    <span class="text-[#4fd1c5]">{{ $course->is_free ? 'Apply' : 'Checkout' }}</span>
                </nav>

                <h1 class="text-3xl sm:text-4xl font-black text-white tracking-tight mb-3">
                    {{ $course->is_free ? 'Course Admission Application' : 'Course Enrollment & Checkout' }}
                </h1>
                <p class="text-sm sm:text-base text-gray-300">
                    Applying for <strong class="text-[#4fd1c5]">{{ $course->title }}</strong>
                    @if ($course->batch_no) ({{ $course->batch_no }}) @endif
                </p>
            </div>
        </section>

        {{-- 2. APPLICATION / CHECKOUT FORM --}}
        <section class="py-12 md:py-16 bg-gray-50"
            x-data="courseCheckout({
                isFree: {{ $course->is_free ? 'true' : 'false' }},
                basePrice: {{ $effectivePrice }},
                symbol: '{{ $symbol }}',
                validateUrl: '{{ route('courses.validate-coupon', $course->slug) }}',
                csrfToken: '{{ csrf_token() }}'
            })">
            <div class="max-w-6xl mx-auto px-5 lg:px-12">

                @if (session('error'))
                    <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm flex items-center gap-3">
                        <i class="bi bi-exclamation-triangle-fill text-lg shrink-0"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
                        <strong class="block mb-1">Please fix the following errors:</strong>
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('courses.apply.store', $course->slug) }}" method="POST">
                    @csrf
                    <input type="hidden" name="coupon_code" x-model="appliedCouponCode">

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                        {{-- Left Column: Student Profile & Screening --}}
                        <div class="lg:col-span-8 space-y-6">

                            {{-- Personal Info --}}
                            <div class="bg-white rounded-2xl border border-gray-200/80 p-6 md:p-8 shadow-sm">
                                <h2 class="text-xl font-extrabold text-gray-900 mb-5 flex items-center gap-2">
                                    <span class="w-7 h-7 rounded-full bg-teal-50 text-[#2c988e] text-xs font-black flex items-center justify-center">1</span>
                                    <span>Personal & Contact Information</span>
                                </h2>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 mb-1.5" for="student_name">Full Name <span class="text-red-500">*</span></label>
                                        <input type="text" id="student_name" name="student_name" value="{{ old('student_name') }}" required
                                            placeholder="Your full name"
                                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-[#38b2a6] focus:ring-2 focus:ring-[#4fd1c5]/20">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 mb-1.5" for="email">Email Address <span class="text-red-500">*</span></label>
                                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                            placeholder="you@example.com"
                                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-[#38b2a6] focus:ring-2 focus:ring-[#4fd1c5]/20">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 mb-1.5" for="phone">Phone Number <span class="text-red-500">*</span></label>
                                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required
                                            placeholder="01XXXXXXXXX"
                                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-[#38b2a6] focus:ring-2 focus:ring-[#4fd1c5]/20">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 mb-1.5" for="alt_phone">Alternative Phone</label>
                                        <input type="text" id="alt_phone" name="alt_phone" value="{{ old('alt_phone') }}"
                                            placeholder="Optional"
                                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-[#38b2a6] focus:ring-2 focus:ring-[#4fd1c5]/20">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 mb-1.5" for="gender">Gender</label>
                                        <select id="gender" name="gender"
                                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm bg-white focus:outline-none focus:border-[#38b2a6]">
                                            <option value="">Select</option>
                                            <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                                            <option value="Other" {{ old('gender') === 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 mb-1.5" for="present_address">Present Address <span class="text-red-500">*</span></label>
                                        <input type="text" id="present_address" name="present_address" value="{{ old('present_address') }}" required
                                            placeholder="e.g. Mirpur 10, Dhaka"
                                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-[#38b2a6] focus:ring-2 focus:ring-[#4fd1c5]/20">
                                    </div>
                                </div>
                            </div>

                            {{-- Academic & Screening Info --}}
                            <div class="bg-white rounded-2xl border border-gray-200/80 p-6 md:p-8 shadow-sm">
                                <h2 class="text-xl font-extrabold text-gray-900 mb-5 flex items-center gap-2">
                                    <span class="w-7 h-7 rounded-full bg-teal-50 text-[#2c988e] text-xs font-black flex items-center justify-center">2</span>
                                    <span>Background & Screening Questions</span>
                                </h2>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 mb-1.5" for="educational_qualification">Educational Qualification <span class="text-red-500">*</span></label>
                                        <input type="text" id="educational_qualification" name="educational_qualification" value="{{ old('educational_qualification') }}" required
                                            placeholder="e.g. B.Sc in CSE / Diploma / HSC"
                                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-[#38b2a6] focus:ring-2 focus:ring-[#4fd1c5]/20">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 mb-1.5" for="current_profession">Current Profession / Institute <span class="text-red-500">*</span></label>
                                        <input type="text" id="current_profession" name="current_profession" value="{{ old('current_profession') }}" required
                                            placeholder="e.g. Student @ DIU / Fresh Graduate"
                                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-[#38b2a6] focus:ring-2 focus:ring-[#4fd1c5]/20">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 mb-1.5" for="experience_level">Current Skill Level <span class="text-red-500">*</span></label>
                                        <select id="experience_level" name="experience_level" required
                                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm bg-white focus:outline-none focus:border-[#38b2a6]">
                                            <option value="Beginner" {{ old('experience_level') === 'Beginner' ? 'selected' : '' }}>Beginner</option>
                                            <option value="Intermediate" {{ old('experience_level') === 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                                            <option value="Advanced" {{ old('experience_level') === 'Advanced' ? 'selected' : '' }}>Advanced</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 mb-1.5" for="portfolio_or_github">GitHub / Portfolio Link <span class="text-gray-400">(Optional)</span></label>
                                        <input type="url" id="portfolio_or_github" name="portfolio_or_github" value="{{ old('portfolio_or_github') }}"
                                            placeholder="https://github.com/username"
                                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-[#38b2a6] focus:ring-2 focus:ring-[#4fd1c5]/20">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1.5" for="why_this_course">
                                        Why do you want to join this course? <span class="text-red-500">*</span>
                                    </label>
                                    <textarea id="why_this_course" name="why_this_course" rows="4" required
                                        placeholder="Tell us about your learning goals, commitment to attend classes, and what you hope to build..."
                                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-[#38b2a6] focus:ring-2 focus:ring-[#4fd1c5]/20">{{ old('why_this_course') }}</textarea>
                                    <p class="text-[11px] text-gray-400 mt-1">Minimum 20 characters. This helps our team shortlist candidates for interviews.</p>
                                </div>
                            </div>

                            {{-- Payment Section (Paid Courses Only) --}}
                            @if (!$course->is_free && $effectivePrice > 0)
                                <div class="bg-white rounded-2xl border border-gray-200/80 p-6 md:p-8 shadow-sm" x-show="payable > 0">
                                    <h2 class="text-xl font-extrabold text-gray-900 mb-3 flex items-center gap-2">
                                        <span class="w-7 h-7 rounded-full bg-teal-50 text-[#2c988e] text-xs font-black flex items-center justify-center">3</span>
                                        <span>Manual Payment Information</span>
                                    </h2>
                                    <p class="text-xs text-gray-500 mb-5">
                                        Send <strong class="text-gray-900" x-text="symbol + payable.toFixed(2)"></strong> via bKash / Nagad / Rocket (Send Money) and enter your Transaction ID below. Your enrollment is activated immediately while our team verifies your TrxID.
                                    </p>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 mb-1.5" for="payment_method">Payment Method <span class="text-red-500">*</span></label>
                                            <select id="payment_method" name="payment_method"
                                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm bg-white focus:outline-none focus:border-[#38b2a6]">
                                                <option value="bkash" {{ old('payment_method') === 'bkash' ? 'selected' : '' }}>bKash</option>
                                                <option value="nagad" {{ old('payment_method') === 'nagad' ? 'selected' : '' }}>Nagad</option>
                                                <option value="rocket" {{ old('payment_method') === 'rocket' ? 'selected' : '' }}>Rocket</option>
                                                <option value="bank" {{ old('payment_method') === 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 mb-1.5" for="sender_phone_number">Sender Phone Number <span class="text-red-500">*</span></label>
                                            <input type="text" id="sender_phone_number" name="sender_phone_number" value="{{ old('sender_phone_number') }}"
                                                placeholder="01XXXXXXXXX"
                                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-[#38b2a6]">
                                        </div>

                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 mb-1.5" for="transaction_id">Transaction ID (TrxID) <span class="text-red-500">*</span></label>
                                            <input type="text" id="transaction_id" name="transaction_id" value="{{ old('transaction_id') }}"
                                                placeholder="e.g. 9G7K2L1M4P"
                                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm uppercase focus:outline-none focus:border-[#38b2a6]">
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>

                        {{-- Right Column: Summary & Coupon --}}
                        <div class="lg:col-span-4">
                            <div class="sticky top-28 bg-white rounded-2xl border border-gray-200 shadow-lg p-6">
                                <h3 class="text-lg font-extrabold text-gray-900 mb-4">Program Summary</h3>

                                <div class="pb-4 mb-4 border-b border-gray-100">
                                    <div class="text-sm font-bold text-gray-900">{{ $course->title }}</div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $course->delivery_mode->label() }}
                                        @if ($course->batch_no) • {{ $course->batch_no }} @endif
                                    </div>
                                    @if ($course->venue)
                                        <div class="text-xs text-gray-500 mt-1"><i class="bi bi-geo-alt text-[#38b2a6]"></i> {{ $course->venue }}</div>
                                    @endif
                                </div>

                                @if (!$course->is_free && $effectivePrice > 0)
                                    {{-- Coupon Box --}}
                                    <div class="mb-5">
                                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Have a Discount Coupon?</label>
                                        <div class="flex gap-2">
                                            <input type="text" x-model="couponInput" placeholder="Enter code"
                                                class="flex-grow px-3 py-2 rounded-xl border border-gray-200 text-xs uppercase focus:outline-none focus:border-[#38b2a6]">
                                            <button type="button" @click="applyCoupon()" :disabled="loadingCoupon"
                                                class="px-4 py-2 rounded-xl bg-black text-white text-xs font-bold hover:bg-gray-800 transition-colors disabled:opacity-50">
                                                <span x-text="loadingCoupon ? '...' : 'Apply'"></span>
                                            </button>
                                        </div>
                                        <p x-show="couponMessage" x-text="couponMessage"
                                            :class="couponValid ? 'text-emerald-600' : 'text-red-500'"
                                            class="text-xs mt-1.5 font-medium"></p>
                                    </div>

                                    {{-- Price Breakdown --}}
                                    <div class="space-y-2 text-sm pb-4 mb-5 border-b border-gray-100">
                                        <div class="flex justify-between text-gray-600">
                                            <span>Course Fee</span>
                                            <span>{{ $symbol }}{{ number_format($effectivePrice, 2) }}</span>
                                        </div>
                                        <div class="flex justify-between text-emerald-600" x-show="discount > 0">
                                            <span>Coupon Discount</span>
                                            <span x-text="'-' + symbol + discount.toFixed(2)"></span>
                                        </div>
                                        <div class="flex justify-between font-black text-gray-900 text-base pt-2 border-t border-gray-100">
                                            <span>Total Payable</span>
                                            <span x-text="symbol + payable.toFixed(2)"></span>
                                        </div>
                                    </div>
                                @else
                                    <div class="p-4 rounded-xl bg-teal-50/70 border border-teal-100 mb-5">
                                        <div class="text-xs font-bold text-[#2c988e] uppercase mb-1">Free Scholarship Program</div>
                                        <p class="text-xs text-gray-600 leading-relaxed">
                                            No payment required. After submitting, our team will review your profile and contact shortlisted candidates for an interview.
                                        </p>
                                    </div>
                                @endif

                                <button type="submit"
                                    class="w-full inline-flex items-center justify-center gap-2 bg-[#4fd1c5] hover:bg-[#38b2a6] text-black font-extrabold py-3.5 px-6 rounded-xl text-sm transition-all shadow-[0_4px_15px_rgba(79,209,197,0.35)]">
                                    <span>{{ $course->is_free ? 'Submit Application' : 'Complete Enrollment' }}</span>
                                    <i class="bi bi-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script>
        function courseCheckout(config) {
            return {
                isFree: config.isFree,
                basePrice: config.basePrice,
                symbol: config.symbol,
                couponInput: '',
                appliedCouponCode: '',
                discount: 0,
                payable: config.basePrice,
                couponMessage: '',
                couponValid: false,
                loadingCoupon: false,

                async applyCoupon() {
                    if (!this.couponInput.trim()) return;
                    this.loadingCoupon = true;
                    this.couponMessage = '';

                    try {
                        const res = await fetch(config.validateUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': config.csrfToken,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({ code: this.couponInput.trim() })
                        });
                        const data = await res.json();

                        if (res.ok && data.valid) {
                            this.couponValid = true;
                            this.appliedCouponCode = data.code;
                            this.discount = parseFloat(data.discount);
                            this.payable = parseFloat(data.payable);
                            this.couponMessage = data.message;
                        } else {
                            this.couponValid = false;
                            this.appliedCouponCode = '';
                            this.discount = 0;
                            this.payable = this.basePrice;
                            this.couponMessage = data.message || 'Invalid coupon code.';
                        }
                    } catch (e) {
                        this.couponValid = false;
                        this.couponMessage = 'Could not validate coupon right now.';
                    } finally {
                        this.loadingCoupon = false;
                    }
                }
            }
        }
    </script>
@endpush
