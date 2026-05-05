@extends('layouts.site')

@section('title', __('Library - Creator File Storage'))

@section('content')
<div class="section" style="margin-top:0;">
    <div class="eyebrow">{{ __('Asset library') }}</div>
    <h1 style="font-size:clamp(28px,5vw,42px);">{{ __('File Library') }}</h1>
    <p>{{ __('Search the catalog by file type, software, and name. Each item has a dedicated details page.') }}</p>
    <div class="actions">
        @if(in_array(session('user_role'), ['admin', 'creator']))
            <a class="btn primary" href="{{ route('file.upload.show') }}">{{ __('Add New File') }}</a>
        @elseif(session('logged_in'))
            <a class="btn primary" href="{{ route('profile') }}">{{ __('View Your Role') }}</a>
        @else
            <a class="btn primary" href="{{ route('midterm') }}">{{ __('Login to Upload') }}</a>
        @endif
    </div>
</div>

@if(session('upload_success'))
    <div class="alert success">{{ session('upload_success') }}</div>
@endif

<section class="stats">
    <div class="stat"><strong>{{ $files->count() }}</strong><span>{{ __('Total files') }}</span></div>
    <div class="stat"><strong>{{ $files->where('file_type', 'lut')->count() }}</strong><span>LUTs</span></div>
    <div class="stat"><strong>{{ $files->where('file_type', 'preset')->count() }}</strong><span>Presets</span></div>
    <div class="stat"><strong>{{ $files->where('file_type', 'project')->count() }}</strong><span>Projects</span></div>
</section>

<section class="section">
    <div class="card" style="margin-bottom:18px;">
        <div class="grid two">
            <div class="field" style="margin-bottom:0;">
                <label for="librarySearch">{{ __('Search files') }}</label>
                <input id="librarySearch" placeholder="{{ __('Search by name or software') }}">
            </div>
            <div class="field" style="margin-bottom:0;">
                <label for="typeFilter">{{ __('Filter by type') }}</label>
                <select id="typeFilter">
                    <option value="">{{ __('All types') }}</option>
                    @foreach($types as $type)
                        <option value="{{ strtolower($type) }}">{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="grid three">
        @foreach($files as $file)
            <a class="card file-card" href="{{ route('details', $file) }}" data-name="{{ strtolower($file->name) }}" data-software="{{ strtolower($file->software ?? '') }}" data-type="{{ strtolower($file->file_type ?? '') }}">
                <span class="pill">{{ strtoupper($file->file_type ?? 'file') }}</span>
                <h3 style="margin-top:14px;">{{ $file->name }}</h3>
                <p>{{ $file->description ?: __('No description added yet.') }}</p>
                <p class="muted">{{ $file->software ?? __('Any software') }}</p>
            </a>
        @endforeach
    </div>
    @if($files->isEmpty())
        <div class="card"><h3>{{ __('The library is empty.') }}</h3><p>{{ __('Upload a file to start building the website content.') }}</p></div>
    @endif
</section>

<script>
    const searchInput = document.getElementById('librarySearch');
    const typeFilter = document.getElementById('typeFilter');
    const cards = Array.from(document.querySelectorAll('.file-card'));

    function filterLibrary() {
        const query = searchInput.value.toLowerCase().trim();
        const type = typeFilter.value;

        cards.forEach(card => {
            const matchesQuery = !query || card.dataset.name.includes(query) || card.dataset.software.includes(query);
            const matchesType = !type || card.dataset.type === type;
            card.style.display = matchesQuery && matchesType ? 'block' : 'none';
        });
    }

    searchInput.addEventListener('input', filterLibrary);
    typeFilter.addEventListener('change', filterLibrary);
</script>
@endsection
