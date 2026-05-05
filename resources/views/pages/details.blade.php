@extends('layouts.site')

@section('title', $file->name . ' - ' . __('Creator File Storage'))

@section('content')
<section class="grid two">
    <div class="card soft">
        <span class="pill">{{ strtoupper($file->file_type ?? 'file') }}</span>
        <h1 style="font-size:clamp(34px,5vw,58px); margin-top:18px;">{{ $file->name }}</h1>
        <p>{{ $file->description ?: __('This asset is ready to be used in a creator workflow.') }}</p>
        <div class="actions">
            @if($file->file_path && in_array(session('user_role'), ['admin', 'premium']))
                <a class="btn primary" href="{{ route('download', $file) }}">{{ __('Download') }}</a>
            @elseif($file->file_path)
                <a class="btn primary" href="{{ route('midterm') }}">{{ __('Premium Login to Download') }}</a>
            @endif
            <a class="btn" href="{{ route('library') }}">{{ __('Back to Library') }}</a>
        </div>
        @if($file->file_path && !in_array(session('user_role'), ['admin', 'premium']))
            <p class="muted" style="margin-top:18px;">{{ __('Viewer and guest accounts can browse file details. Premium users and admins can download files.') }}</p>
        @endif
    </div>
    <div class="card">
        <h2>{{ __('File Details') }}</h2>
        <div class="detail-list">
            <div><span class="muted">{{ __('Original file') }}</span><strong>{{ $file->original_filename ?? __('Not specified') }}</strong></div>
            <div><span class="muted">{{ __('Type') }}</span><strong>{{ ucfirst($file->file_type ?? __('Other')) }}</strong></div>
            <div><span class="muted">{{ __('Software') }}</span><strong>{{ $file->software ?? __('Any software') }}</strong></div>
            <div><span class="muted">{{ __('Size') }}</span><strong>{{ round(($file->file_size ?? 0) / 1048576, 2) }} MB</strong></div>
            <div><span class="muted">{{ __('Downloads') }}</span><strong>{{ $file->download_count ?? 0 }}</strong></div>
            <div><span class="muted">{{ __('Added') }}</span><strong>{{ $file->created_at?->format('d M Y') }}</strong></div>
        </div>
    </div>
</section>
@endsection
