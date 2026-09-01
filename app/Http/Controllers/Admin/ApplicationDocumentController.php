<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApplicationDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ApplicationDocumentController extends Controller
{
    /**
     * View (inline) a document — for images and PDFs.
     * Only accessible to admin users (enforced via route middleware).
     */
    public function view(ApplicationDocument $document): StreamedResponse|\Illuminate\Http\Response
    {
        abort_unless($document->storageExists(), 404, 'Document not found in storage.');

        $disk = $document->disk ?? 'local';
        $path = $document->stored_path;

        $content  = Storage::disk($disk)->get($path);
        $mimeType = $document->mime_type ?? 'application/octet-stream';

        // For images and PDFs, serve inline (browser preview)
        if ($document->isImage() || $document->isPdf()) {
            return response($content, 200)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'inline; filename="' . $document->original_name . '"')
                ->header('X-Frame-Options', 'SAMEORIGIN')
                ->header('Cache-Control', 'no-store, no-cache, must-revalidate');
        }

        // Anything else — force download
        return response($content, 200)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'attachment; filename="' . $document->original_name . '"')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate');
    }

    /**
     * Force-download a document.
     * Only accessible to admin users (enforced via route middleware).
     */
    public function download(ApplicationDocument $document): StreamedResponse
    {
        abort_unless($document->storageExists(), 404, 'Document not found in storage.');

        $disk = $document->disk ?? 'local';

        return Storage::disk($disk)->download(
            $document->stored_path,
            $document->original_name,
            [
                'Content-Type'              => $document->mime_type ?? 'application/octet-stream',
                'Cache-Control'             => 'no-store, no-cache, must-revalidate',
                'Content-Security-Policy'   => "default-src 'none'",
            ]
        );
    }
}
