@extends('layouts.site')

@section('title', __('Profile - Creator File Storage'))

@section('content')
<section class="grid two">
    <div class="card">
        <div class="eyebrow">{{ __('User profile') }}</div>
        <h1 style="font-size:clamp(32px,5vw,54px);">{{ session('user_name') }}</h1>
        <p>{{ session('user_email') }}</p>
        <div class="detail-list">
            <div><span class="muted">{{ __('Role') }}</span><strong>{{ __(ucfirst(session('user_role') ?? 'viewer')) }}</strong></div>
            <div><span class="muted">{{ __('Uploaded files') }}</span><strong>{{ $files->count() }}</strong></div>
            <div><span class="muted">{{ __('Storage used') }}</span><strong>{{ round($totalStorage / 1048576, 2) }} MB</strong></div>
        </div>
    </div>
    <div class="card">
        <h2>{{ __('Role Possibilities') }}</h2>
        @if(session('user_role') === 'admin')
            <p>{{ __('Admin has full access: upload files, download files, delete uploads, and change user roles.') }}</p>
        @elseif(session('user_role') === 'creator')
            <p>{{ __('Creator can upload new LUTs, presets, and project files, and manage uploaded files.') }}</p>
        @elseif(session('user_role') === 'premium')
            <p>{{ __('Premium can browse the library and download available creative files.') }}</p>
        @else
            <p>{{ __('Viewer can browse the library and open file details. Upload and download are limited by role.') }}</p>
        @endif
        <div class="actions">
            @if(in_array(session('user_role'), ['admin', 'creator']))
                <a class="btn primary" href="{{ route('file.upload.show') }}">{{ __('Upload More Files') }}</a>
            @else
                <a class="btn primary" href="{{ route('library') }}">{{ __('Browse Library') }}</a>
            @endif
        </div>
    </div>
</section>

<section class="section">
    <h2>{{ __('Your Uploaded Files') }}</h2>
    <div class="table-wrap">
        <table>
            <thead><tr><th>{{ __('Filename') }}</th><th>{{ __('Type') }}</th><th>{{ __('Size') }}</th><th>{{ __('Uploaded') }}</th></tr></thead>
            <tbody>
                @forelse($files as $file)
                    <tr>
                        <td>{{ $file->original_name }}</td>
                        <td>{{ $file->mime_type ?? __('unknown') }}</td>
                        <td>{{ $file->file_size_human }}</td>
                        <td>{{ $file->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="muted">{{ __('No uploaded files connected to this account yet.') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

@if(session('user_role') === 'admin')
<section class="section">
    <h2>{{ __('Admin User Management') }}</h2>
    <div class="table-wrap">
        <table>
            <thead><tr><th>{{ __('Name') }}</th><th>{{ __('Email') }}</th><th>{{ __('Current Role') }}</th><th>{{ __('Change Role') }}</th></tr></thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td><span class="pill">{{ $user->role?->name ?? 'none' }}</span></td>
                        <td>
                            <form method="POST" action="{{ route('admin.changeRole') }}" style="display:flex;gap:8px;align-items:center;">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <select name="role" style="max-width:150px;">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ $user->role?->name === $role->name ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                                    @endforeach
                                </select>
                                <button class="btn primary" type="submit">{{ __('Save') }}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endif
@endsection
