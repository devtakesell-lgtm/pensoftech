@extends('frontend.layouts.front-master')

@section('title', 'Application Confirmed — PenSoftTech Academy')

@section('content')
    @php
        $isFree = $application->course?->is_free ?? true;
    @endphp

    <main class="bg-gray-50 min-h-[85vh] pt-36 pb-20">
        <div class="max-w-3xl mx-auto px-5">
            <div class="bg-white rounded-3xl border border-gray-200 shadow-lg p-8 md:p-12 text-center">
                <div class="w-20 h-20 mx-auto rounded-full bg-teal-50 text-[#2c988e] flex items-center justify-center text-4xl mb-6">
                    <i class="bi bi-check-circle-fill"></i>
                </div>

                @if ($isFree)
                    <span class="inline-block px-3.5 py-1 rounded-full bg-teal-50 text-[#2c988e] text-xs font-extrabold uppercase tracking-wider mb-3">
                        Application Received
                    </span>
                    <h1 class="text-3xl sm:text-4xl font-black text-gray-900 mb-3">
                        Thank You, {{ $application->student_name }}!
                    </h1>
                    <p class="text-gray-600 text-sm sm:text-base max-w-xl mx-auto mb-8 leading-relaxed">
                        আপনার আবেদনটি সফলভাবে জমা হয়েছে। আমাদের টিম আপনার তথ্য যাচাই-বাছাই (Screening) করে শর্টলিস্টেড হলে ইন্টারভিউয়ের জন্য আপনার সাথে যোগাযোগ করবে।
                    </p>
                @else
                    <span class="inline-block px-3.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-extrabold uppercase tracking-wider mb-3">
                        Enrollment Confirmed
                    </span>
                    <h1 class="text-3xl sm:text-4xl font-black text-gray-900 mb-3">
                        Welcome to PenSoftTech Academy!
                    </h1>
                    <p class="text-gray-600 text-sm sm:text-base max-w-xl mx-auto mb-8 leading-relaxed">
                        Your enrollment for <strong>{{ $application->course?->title }}</strong> is complete! Our finance team will verify your payment TrxID shortly.
                    </p>
                @endif

                <div class="bg-gray-50 rounded-2xl border border-gray-200/80 p-6 text-left max-w-lg mx-auto mb-8 space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Application Number:</span>
                        <strong class="text-gray-900">{{ $application->application_no }}</strong>
                    </div>
                    @if ($application->learner)
                        <div class="flex justify-between">
                            <span class="text-gray-500">Learner ID:</span>
                            <strong class="text-[#2c988e]">{{ $application->learner->learner_code }}</strong>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-gray-500">Course:</span>
                        <strong class="text-gray-900">{{ $application->course?->title }}</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Current Status:</span>
                        <strong class="text-[#2c988e]">{{ $application->status->label() }}</strong>
                    </div>
                </div>

                <div class="flex flex-wrap justify-center gap-3">
                    <a href="{{ route('courses.index') }}"
                        class="px-6 py-3 rounded-full bg-black text-white font-bold text-sm hover:bg-gray-800 transition-colors">
                        Browse More Courses
                    </a>
                    <a href="{{ route('home') }}"
                        class="px-6 py-3 rounded-full border border-gray-200 text-gray-700 font-bold text-sm hover:bg-gray-50 transition-colors">
                        Back to Home
                    </a>
                </div>
            </div>
        </div>
    </main>
@endsection
