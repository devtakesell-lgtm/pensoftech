@extends('frontend.layouts.front-master')

@section('title', 'Our Projects — PenSoftTech')
@section('meta_description', 'Explore our portfolio of scalable software solutions and enterprise projects.')

@section('content')
    <main class="bg-black min-h-screen pt-40 pb-24 relative overflow-hidden">
        {{-- Background Glow --}}
        <div class="absolute top-0 right-0 w-1/2 h-1/2 bg-[#4fd1c5]/10 rounded-full blur-[150px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-5 lg:px-12 relative z-10">
            <div class="text-center mb-16 md:mb-24">
                <span class="text-[#4fd1c5] font-bold tracking-widest uppercase text-xs md:text-sm mb-3 block">Portfolio</span>
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white tracking-tight leading-tight">
                    Our <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#4fd1c5] to-[#2c988e]">Projects</span>
                </h1>
                <p class="text-gray-400 mt-6 max-w-2xl mx-auto text-lg md:text-xl leading-relaxed">
                    Discover how we build scalable, high-performance solutions for leading enterprises worldwide.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
                @foreach ($projects as $project)
                    <a href="{{ route('projects.single', $project->slug) }}" class="group block relative rounded-3xl overflow-hidden border border-white/10 aspect-[4/5] bg-[#050505] transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_20px_40px_-15px_rgba(79,209,197,0.2)] hover:border-[#4fd1c5]/30" data-cursor-expand>
                        
                        {{-- Image --}}
                        <div class="absolute inset-0 w-full h-[65%] overflow-hidden">
                            <img src="{{ filter_var($project->featured_image, FILTER_VALIDATE_URL) ? $project->featured_image : Storage::url($project->featured_image) }}" 
                                alt="{{ $project->title }}" 
                                class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#050505] via-[#050505]/80 to-transparent"></div>
                        </div>

                        {{-- Content Box --}}
                        <div class="absolute bottom-0 left-0 right-0 p-8 pt-20 flex flex-col justify-end">
                            <div class="mb-4">
                                <span class="inline-block px-3 py-1 bg-[#4fd1c5]/10 text-[#4fd1c5] text-[10px] font-bold tracking-widest uppercase rounded-full border border-[#4fd1c5]/20 mb-3">
                                    {{ $project->industry?->name ?? 'Project' }}
                                </span>
                                <h2 class="text-2xl font-bold text-white group-hover:text-[#4fd1c5] transition-colors duration-300 leading-tight">
                                    {{ $project->title }}
                                </h2>
                            </div>
                            
                            <p class="text-gray-400 text-sm leading-relaxed mb-6 line-clamp-2">
                                {{ $project->short_description }}
                            </p>

                            <div class="flex items-center text-white text-sm font-semibold group-hover:text-[#4fd1c5] transition-colors">
                                View Case Study 
                                <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-16 flex justify-center">
                {{ $projects->links('pagination::tailwind') }}
            </div>
        </div>
    </main>
@endsection
