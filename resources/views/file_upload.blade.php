@extends('layouts.site')

@section('title', __('Upload - Creator File Storage'))

@section('content')
<div class="section" style="margin-top:0;">
    <div class="eyebrow">{{ __('Add new files') }}</div>
    <h1 style="font-size:clamp(28px,5vw,42px);">{{ __('Upload Files') }}</h1>
    <p>{{ __('Fill in the metadata so other creators can quickly understand what the file is for.') }}</p>
</div>

<section class="grid two section">
    <div class="card">
        <h2>{{ __('Upload File') }}</h2>
        <form method="POST" action="{{ route('file.upload') }}" enctype="multipart/form-data">
            @csrf
            <div class="field">
                <label for="name">{{ __('Display name') }}</label>
                <input id="name" name="name" placeholder="{{ __('Cinematic Teal Orange LUT') }}" required>
            </div>
            <div class="field">
                <label for="file_type">{{ __('File type') }}</label>
                <select id="file_type" name="file_type" required>
                    <option value="lut">LUT</option>
                    <option value="preset">{{ __('Preset') }}</option>
                    <option value="project">{{ __('Project') }}</option>
                    <option value="other">{{ __('Other') }}</option>
                </select>
            </div>
            <div class="field">
                <label for="software">{{ __('Software') }}</label>
                <input id="software" name="software" placeholder="Premiere Pro, DaVinci Resolve, Lightroom">
            </div>
            <div class="field">
                <label for="description">{{ __('Description') }}</label>
                <textarea id="description" name="description" placeholder="{{ __('Describe the style, use case, or included files.') }}"></textarea>
            </div>
            <div class="field">
                <label for="file">{{ __('File') }}</label>
                <input id="file" type="file" name="file" required>
                <p class="muted" style="margin:8px 0 0;">{{ __('Maximum size: 20 MB.') }}</p>
            </div>
            <button class="btn primary" type="submit">{{ __('Upload File') }}</button>
        </form>
    </div>

    <div class="card">
        <h2>{{ __('Upload Guidelines') }}</h2>
        <p>{{ __('Use clear names, select the right category, and mention the editing software. This makes the library easier to browse for video editors and photographers.') }}</p>
        <div class="stats" style="grid-template-columns:repeat(2,1fr);">
            <div class="stat"><strong>{{ $files->count() }}</strong><span>{{ __('Server uploads') }}</span></div>
            <div class="stat"><strong>{{ round($files->sum('file_size') / 1048576, 1) }} MB</strong><span>{{ __('Total size') }}</span></div>
        </div>
    </div>
</section>

<section class="section">
    <h2>{{ __('Uploaded files') }}</h2>
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>{{ __('Filename') }}</th><th>{{ __('Type') }}</th><th>{{ __('Size') }}</th><th>{{ __('Uploaded') }}</th><th>{{ __('Action') }}</th></tr>
            </thead>
            <tbody>
                @forelse($files as $file)
                    <tr>
                        <td>{{ $file->original_name }}</td>
                        <td>{{ $file->mime_type ?? __('unknown') }}</td>
                        <td>{{ $file->file_size_human }}</td>
                        <td>{{ $file->created_at->format('d M Y, H:i') }}</td>
                        <td>
                            <form method="POST" action="{{ route('file.delete', $file->id) }}" onsubmit="return confirm('{{ __('Delete this file?') }}')">
                                @csrf
                                @method('DELETE')
                                <button class="btn danger" type="submit">{{ __('Delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="muted">{{ __('No files uploaded yet.') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
