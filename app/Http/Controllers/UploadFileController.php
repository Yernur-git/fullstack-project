<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UploadedFile;
use Illuminate\Support\Facades\Storage;
class UploadFileController extends Controller
{
    private function canUpload(): bool
    {
        return in_array(session('user_role'), ['admin', 'creator']);
    }

    public function show()
    {
        if (!$this->canUpload()) {
            return redirect()->route('library')->with('error', __('Only admins and creators can upload files.'));
        }

        $files = UploadedFile::latest()->get();
        return view('file_upload', compact('files'));
    }

    public function upload(Request $request)
    {
        if (!$this->canUpload()) {
            return redirect()->route('library')->with('error', __('Only admins and creators can upload files.'));
        }

        $request->validate([
            'file'      => 'required|file|max:20480',
            'name'      => 'required|string|max:255',
            'file_type' => 'required|in:lut,preset,project,other',
        ]);

        $file         = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $storedName   = time() . '_' . $originalName;
        $path         = $file->storeAs('uploads', $storedName, 'public');

        \App\Models\UploadedFile::create([
            'original_name' => $originalName,
            'stored_name'   => $storedName,
            'file_path'     => $path,
            'mime_type'     => $file->getMimeType(),
            'file_size'     => $file->getSize(),
            'user_id'       => session('user_id'),
        ]);

        \App\Models\CreatorFile::create([
            'name'              => $request->name,
            'original_filename' => $originalName,
            'file_path'         => $path,
            'file_type'         => $request->file_type,
            'software'          => $request->software,
            'file_size'         => $file->getSize(),
            'description'       => $request->description,
        ]);

        return redirect()->route('library')
                        ->with('upload_success', __('File ":name" uploaded successfully!', ['name' => $request->name]));
    }

    public function delete($id)
    {
        if (!$this->canUpload()) {
            return redirect()->route('library')->with('error', __('Only admins and creators can delete uploaded files.'));
        }

        $file = UploadedFile::findOrFail($id);
        Storage::disk('public')->delete($file->file_path);
        $file->delete();

        return redirect()->route('file.upload.show')
                         ->with('success', __('File deleted successfully.'));
    }
}
