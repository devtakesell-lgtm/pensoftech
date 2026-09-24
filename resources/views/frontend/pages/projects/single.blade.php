@extends('frontend.layouts.front-master')

@if ($project->seo)
    @section('title', $project->seo->meta_title ?? $project->title)
    @section('meta_description', $project->seo->meta_description)
    @section('meta_keywords', $project->seo->meta_keywords)
@else
    @section('title', $project->title . ' — PenSoftTech Projects')
@endif

@section('content')
    <main class="bg-white min-h-screen pt-40 pb-24 relative">
        
        {{-- Hero Header --}}
        <div class="max-w-7xl mx-auto px-5 lg:px-12 mb-16 relative">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-12">
                <div class="max-w-4xl">
                    <div class="flex flex-wrap items-center gap-3 mb-6">
                        @if($project->industry)
                        <span class="inline-block px-4 py-1.5 bg-[#4fd1c5]/10 text-[#2c988e] text-xs font-bold rounded-full uppercase tracking-wider">
                            {{ $project->industry->name }}
                        </span>
                        @endif
                        <span class="inline-block px-4 py-1.5 bg-gray-100 text-gray-600 text-xs font-bold rounded-full uppercase tracking-wider">
                            {{ $project->status->label() ?? 'Project' }}
                        </span>
                    </div>
                    <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-gray-900 tracking-tight leading-[1.1]">
                        {{ $project->title }}
                    </h1>
                </div>
                
                @if($project->project_url)
                <div class="shrink-0">
                    <a href="{{ $project->project_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2 bg-gray-900 hover:bg-[#4fd1c5] text-white px-8 py-4 rounded-full font-bold transition-colors duration-300 shadow-lg">
                        View Live Project
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                </div>
                @endif
            </div>

            {{-- Featured Image --}}
            <div class="w-full aspect-[21/9] md:aspect-[21/8] rounded-[2rem] overflow-hidden shadow-2xl relative">
                <img src="{{ filter_var($project->featured_image, FILTER_VALIDATE_URL) ? $project->featured_image : Storage::url($project->featured_image) }}" 
                     alt="{{ $project->title }}" 
                     class="w-full h-full object-cover">
            </div>
        </div>

        {{-- Project Details Grid --}}
        <div class="max-w-7xl mx-auto px-5 lg:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20">
                
                {{-- Main Content --}}
                <div class="lg:col-span-8">
                    @if ($project->short_description)
                        <p class="text-xl md:text-2xl text-gray-600 font-medium leading-relaxed mb-12">
                            {{ $project->short_description }}
                        </p>
                    @endif

                    {{-- TinyMCE Content --}}
                    <div class="service-content max-w-none">
                        {!! $project->description !!}
                    </div>
                </div>

                {{-- Sidebar Details --}}
                <div class="lg:col-span-4">
                    <div class="bg-gray-50 rounded-3xl p-8 border border-gray-100 sticky top-32">
                        <h3 class="text-xl font-bold text-gray-900 mb-8 border-b border-gray-200 pb-4">Project Overview</h3>
                        
                        <dl class="space-y-6">
                            @if($project->client)
                            <div>
                                <dt class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-1">Client</dt>
                                <dd class="text-lg font-bold text-gray-900">{{ $project->client->company_name ?? $project->client->name }}</dd>
                            </div>
                            @endif

                            @if($project->start_date)
                            <div>
                                <dt class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-1">Timeline</dt>
                                <dd class="text-lg font-bold text-gray-900">
                                    {{ $project->start_date->format('M Y') }} - 
                                    {{ $project->completion_date ? $project->completion_date->format('M Y') : 'Present' }}
                                </dd>
                            </div>
                            @endif

                            @if($project->services->count() > 0)
                            <div>
                                <dt class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Services Provided</dt>
                                <dd class="flex flex-wrap gap-2">
                                    @foreach($project->services as $service)
                                        <span class="px-3 py-1.5 bg-white border border-gray-200 text-gray-700 text-sm font-medium rounded-lg">
                                            {{ $service->name }}
                                        </span>
                                    @endforeach
                                </dd>
                            </div>
                            @endif
                        </dl>
                        
                        {{-- CTA --}}
                        <div class="mt-12 pt-8 border-t border-gray-200">
                            <p class="text-gray-600 font-medium mb-4">Want to build something similar?</p>
                            <a href="{{ route('start-project') }}" class="block w-full text-center bg-[#4fd1c5] hover:bg-[#2c988e] text-white py-4 rounded-xl font-bold transition-colors">
                                Start Your Project
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Case Studies if any --}}
        @if($project->caseStudies->count() > 0)
        <div class="max-w-7xl mx-auto px-5 lg:px-12 mt-32 pt-20 border-t border-gray-100">
            <h2 class="text-3xl md:text-5xl font-extrabold text-gray-900 mb-12 text-center">Related Case Studies</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($project->caseStudies as $study)
                    <a href="#" class="group block relative rounded-[2rem] overflow-hidden aspect-video bg-gray-900">
                        <img src="{{ Storage::url($study->featured_image) }}" alt="{{ $study->title }}" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:opacity-40 group-hover:scale-105 transition-all duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-8 md:p-12">
                            <h3 class="text-2xl md:text-3xl font-bold text-white mb-4">{{ $study->title }}</h3>
                            <div class="flex items-center text-[#4fd1c5] font-bold group-hover:text-white transition-colors">
                                Read Case Study
                                <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif

    </main>
@endsection
