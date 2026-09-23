@extends('frontend.layouts.front-master')

@section('title', 'Start a Project — PenSoftTech')
@section('meta_description', 'Tell us about your next big idea. Get a custom quote and timeline from our software engineering team.')

@section('content')
<div class="bg-[#050b14] min-h-screen text-white pt-24 pb-20 relative overflow-hidden">
    {{-- Background Glows --}}
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-[#4fd1c5]/10 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="max-w-4xl mx-auto px-5 lg:px-8 relative z-10">
        {{-- Header Section --}}
        <div class="text-center mb-12 opacity-0 translate-y-4" x-data x-init="gsap.to($el, {opacity: 1, y: 0, duration: 1, ease: 'power3.out'})">
            <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight mb-4">
                Let's build something <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#4fd1c5] to-blue-500">amazing</span>
            </h1>
            <p class="text-gray-400 text-base md:text-lg max-w-2xl mx-auto">
                Fill out the form below to tell us about your project. Our experts will review your requirements and get back to you with a custom proposal.
            </p>
        </div>

        {{-- Form Container --}}
        <div class="bg-white/5 border border-white/10 rounded-3xl p-6 md:p-10 backdrop-blur-md shadow-2xl opacity-0 translate-y-8" 
             x-data="{ isSubmitting: false }" 
             x-init="gsap.to($el, {opacity: 1, y: 0, duration: 1, delay: 0.2, ease: 'power3.out'})">
            
            @if(session('success'))
                <div class="mb-8 p-4 bg-[#4fd1c5]/20 border border-[#4fd1c5]/50 text-[#4fd1c5] rounded-xl font-medium text-center">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('start-project.store') }}" method="POST" enctype="multipart/form-data" @submit="isSubmitting = true">
                @csrf
                
                {{-- Capture UTM parameters --}}
                <input type="hidden" name="utm_source" value="{{ request()->query('utm_source') }}">
                <input type="hidden" name="utm_medium" value="{{ request()->query('utm_medium') }}">
                <input type="hidden" name="utm_campaign" value="{{ request()->query('utm_campaign') }}">

                <div class="space-y-8">
                    
                    {{-- 1. Contact Information --}}
                    <div>
                        <h3 class="text-xl font-bold mb-4 flex items-center text-white">
                            <span class="w-8 h-8 rounded-full bg-[#4fd1c5]/20 text-[#4fd1c5] flex items-center justify-center text-sm mr-3">1</span> 
                            Contact Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-1.5">
                                <label class="text-sm font-medium text-gray-300">Full Name <span class="text-red-400">*</span></label>
                                <input type="text" name="name" required value="{{ old('name') }}" placeholder="John Doe" 
                                       class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-[#4fd1c5] focus:ring-1 focus:ring-[#4fd1c5] transition-all">
                                @error('name') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="space-y-1.5">
                                <label class="text-sm font-medium text-gray-300">Email Address <span class="text-red-400">*</span></label>
                                <input type="email" name="email" required value="{{ old('email') }}" placeholder="john@company.com" 
                                       class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-[#4fd1c5] focus:ring-1 focus:ring-[#4fd1c5] transition-all">
                                @error('email') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-sm font-medium text-gray-300">Company Name</label>
                                <input type="text" name="company_name" value="{{ old('company_name') }}" placeholder="Your Company Ltd." 
                                       class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-[#4fd1c5] focus:ring-1 focus:ring-[#4fd1c5] transition-all">
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-sm font-medium text-gray-300">Job Title / Designation</label>
                                <input type="text" name="job_title" value="{{ old('job_title') }}" placeholder="Founder, CEO, Manager..." 
                                       class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-[#4fd1c5] focus:ring-1 focus:ring-[#4fd1c5] transition-all">
                            </div>
                            
                            <div class="space-y-1.5">
                                <label class="text-sm font-medium text-gray-300">Phone Number</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+1 (555) 000-0000" 
                                       class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-[#4fd1c5] focus:ring-1 focus:ring-[#4fd1c5] transition-all">
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-sm font-medium text-gray-300">Website URL</label>
                                <input type="url" name="website" value="{{ old('website') }}" placeholder="https://example.com" 
                                       class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-[#4fd1c5] focus:ring-1 focus:ring-[#4fd1c5] transition-all">
                            </div>
                        </div>
                    </div>

                    {{-- 2. Project Details --}}
                    <div>
                        <h3 class="text-xl font-bold mb-4 flex items-center text-white">
                            <span class="w-8 h-8 rounded-full bg-[#4fd1c5]/20 text-[#4fd1c5] flex items-center justify-center text-sm mr-3">2</span> 
                            Project Details
                        </h3>
                        <div class="space-y-5">
                            
                            <div class="space-y-1.5" x-data="{ selectedType: '{{ old('lead_type', '') }}' }">
                                <label class="text-sm font-medium text-gray-300">What do you need help with?</label>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mt-2">
                                    @foreach($leadTypes as $value => $label)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="lead_type" value="{{ $value }}" class="peer sr-only" x-model="selectedType">
                                            <div class="px-4 py-3 rounded-xl border border-white/10 bg-black/30 text-center text-sm font-medium text-gray-400 peer-checked:bg-[#4fd1c5]/10 peer-checked:border-[#4fd1c5] peer-checked:text-white transition-all hover:bg-white/5">
                                                {{ $label }}
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                @php
                                    $sym = $defaultCurrency?->symbol ?? '$';
                                @endphp
                                <label class="text-sm font-medium text-gray-300">Estimated Budget ({{ $defaultCurrency?->code ?? 'USD' }})</label>
                                <select name="budget" class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#4fd1c5] focus:ring-1 focus:ring-[#4fd1c5] transition-all appearance-none">
                                    <option value="" disabled {{ old('budget') ? '' : 'selected' }}>Select a range...</option>
                                    <option value="5000" {{ old('budget') == '5000' ? 'selected' : '' }}>Under {{ $sym }}5,000</option>
                                    <option value="15000" {{ old('budget') == '15000' ? 'selected' : '' }}>{{ $sym }}5,000 - {{ $sym }}15,000</option>
                                    <option value="30000" {{ old('budget') == '30000' ? 'selected' : '' }}>{{ $sym }}15,000 - {{ $sym }}30,000</option>
                                    <option value="50000" {{ old('budget') == '50000' ? 'selected' : '' }}>{{ $sym }}30,000 - {{ $sym }}50,000</option>
                                    <option value="100000" {{ old('budget') == '100000' ? 'selected' : '' }}>{{ $sym }}50,000+</option>
                                </select>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-sm font-medium text-gray-300">Expected Timeline</label>
                                <select name="timeline" class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#4fd1c5] focus:ring-1 focus:ring-[#4fd1c5] transition-all appearance-none">
                                    <option value="" disabled {{ old('timeline') ? '' : 'selected' }}>Select a timeline...</option>
                                    <option value="ASAP" {{ old('timeline') == 'ASAP' ? 'selected' : '' }}>ASAP</option>
                                    <option value="1-3 Months" {{ old('timeline') == '1-3 Months' ? 'selected' : '' }}>1-3 Months</option>
                                    <option value="3-6 Months" {{ old('timeline') == '3-6 Months' ? 'selected' : '' }}>3-6 Months</option>
                                    <option value="Not Sure" {{ old('timeline') == 'Not Sure' ? 'selected' : '' }}>Not Sure</option>
                                </select>
                            </div>

                            <div class="space-y-1.5">
                                <label class="text-sm font-medium text-gray-300">Project Description</label>
                                <textarea name="message" rows="5" placeholder="Tell us about your goals, features you need, and any specific requirements..." 
                                          class="w-full bg-black/50 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-[#4fd1c5] focus:ring-1 focus:ring-[#4fd1c5] transition-all">{{ old('message') }}</textarea>
                            </div>

                            <div class="space-y-1.5" x-data="{ fileName: '' }">
                                <label class="text-sm font-medium text-gray-300">Upload Project Brief or RFP (Optional)</label>
                                <div class="relative w-full">
                                    <input type="file" name="attachment" id="attachment" class="hidden" 
                                           @change="fileName = $event.target.files[0] ? $event.target.files[0].name : ''" 
                                           accept=".pdf,.doc,.docx,.jpg,.png">
                                    <label for="attachment" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-white/10 rounded-xl cursor-pointer hover:border-[#4fd1c5]/50 hover:bg-[#4fd1c5]/5 transition-colors bg-black/30">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-8 h-8 mb-3 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-400" x-show="!fileName"><span class="font-semibold text-white">Click to upload</span> or drag and drop</p>
                                            <p class="text-xs text-gray-500" x-show="!fileName">PDF, DOC, DOCX, PNG, JPG (MAX. 5MB)</p>
                                            <p class="text-sm font-semibold text-[#4fd1c5]" x-show="fileName" x-text="fileName"></p>
                                        </div>
                                    </label>
                                </div>
                                @error('attachment') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                            </div>

                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="pt-4 border-t border-white/10 flex justify-end">
                        <button type="submit" 
                                :disabled="isSubmitting"
                                class="relative inline-flex items-center justify-center px-8 py-4 font-bold text-black transition-all duration-300 bg-[#4fd1c5] rounded-xl hover:bg-[#38b2a6] hover:shadow-[0_0_30px_rgba(79,209,197,0.3)] hover:-translate-y-1 disabled:opacity-70 disabled:cursor-not-allowed">
                            <span x-show="!isSubmitting">Submit Project Inquiry</span>
                            <span x-show="isSubmitting" x-cloak class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Processing...
                            </span>
                            <svg x-show="!isSubmitting" class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection
