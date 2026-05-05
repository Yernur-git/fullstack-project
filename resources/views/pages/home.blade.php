@extends('layouts.site')

@section('title', __('Home - Creator File Storage'))

@section('content')
<section class="hero">
    <div class="eyebrow">{{ __('Creator File Storage') }}</div>
    <h1>{{ __('Store Your Presets. Organize Your Creativity.') }}</h1>
    <p style="max-width:560px;">{{ __('Manage LUTs, presets and project files in one secure place. Built for video editors and photographers.') }}</p>
    <div class="actions">
        <a class="btn primary" href="{{ route('library') }}">{{ __('Browse Library') }}</a>
        @if(in_array(session('user_role'), ['admin', 'creator']))
            <a class="btn" href="{{ route('file.upload.show') }}">{{ __('Upload File') }}</a>
        @else
            <a class="btn" href="{{ route('midterm') }}">{{ __('Login') }}</a>
        @endif
    </div>
    <div class="visual" aria-label="File library preview">
        <div class="visual-row"><strong>{{ __('Cinematic Teal LUT') }}</strong><span class="pill">LUT</span></div>
        <div class="visual-row"><strong>{{ __('Wedding Lightroom Pack') }}</strong><span class="pill">{{ __('Preset') }}</span></div>
        <div class="visual-row"><strong>{{ __('Travel Reel Timeline') }}</strong><span class="pill">{{ __('Project') }}</span></div>
    </div>
</section>

<section class="section">
    <h2 style="text-align:center;">{{ __('User Roles') }}</h2>
    <div class="grid four-role">
        <div class="card"><h3>{{ __('Viewer') }}</h3><p>{{ __('Browses the library and opens details pages.') }}</p></div>
        <div class="card"><h3>{{ __('Premium') }}</h3><p>{{ __('Browses and downloads available files.') }}</p></div>
        <div class="card"><h3>{{ __('Creator') }}</h3><p>{{ __('Uploads and manages creative files.') }}</p></div>
        <div class="card"><h3>{{ __('Admin') }}</h3><p>{{ __('Has full access and manages user roles.') }}</p></div>
    </div>
</section>

<section class="stats">
    <div class="stat"><strong>{{ $totalFiles }}</strong><span>{{ __('Total library files') }}</span></div>
    <div class="stat"><strong>{{ round($totalStorage / 1048576, 1) }} MB</strong><span>{{ __('Stored assets') }}</span></div>
    <div class="stat"><strong>4</strong><span>{{ __('File categories') }}</span></div>
    <div class="stat"><strong>6</strong><span>{{ __('Website pages') }}</span></div>
</section>

<section class="section">
    <h2 style="text-align:center;">{{ __('Main Features') }}</h2>
    <div class="grid three">
        <div class="card" style="text-align:center;"><h3>{{ __('Cloud Storage') }}</h3><p>{{ __('Keep creative files in one place.') }}</p></div>
        <div class="card" style="text-align:center;"><h3>{{ __('Easy Downloads') }}</h3><p>{{ __('Open details and download assets quickly.') }}</p></div>
        <div class="card" style="text-align:center;"><h3>{{ __('Project Management') }}</h3><p>{{ __('Organize files by type and software.') }}</p></div>
    </div>
</section>

<section class="section">
    <h2 style="text-align:center;">{{ __('Recently Added') }}</h2>
    <div class="grid three">
        @forelse($recentFiles as $file)
            <a class="card" href="{{ route('details', $file) }}">
                <span class="pill">{{ strtoupper($file->file_type ?? 'file') }}</span>
                <h3 style="margin-top:14px;">{{ $file->name }}</h3>
                <p>{{ $file->software ?? __('Any software') }}</p>
            </a>
        @empty
            <div class="card"><h3>{{ __('No files yet') }}</h3><p>{{ __('Upload the first LUT, preset, or project file to start the library.') }}</p></div>
        @endforelse
    </div>
</section>
@endsection
