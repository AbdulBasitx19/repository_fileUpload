<?php

namespace App\Http\Controllers;

use App\Services\DocumentService;
use App\Http\Requests\StoreDocumentRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DocumentController extends Controller
{

    protected DocumentService $documentService;

    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }


    public function index(): View
    {
        $publicFiles = $this->documentService->getPublicFiles();
        $privateFiles = $this->documentService->getPrivateFiles();

        return view('documents.index', compact('publicFiles', 'privateFiles'));
    }

    public function store(StoreDocumentRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        
        $file = $request->file('file');
        $title = $validatedData['title'];
        $disk = $validatedData['disk'];

        if ($disk === 'public') {
            $this->documentService->uploadPublicFile($file, $title);
            $message = 'Public file uploaded successfully!';
        } else {
            $this->documentService->uploadPrivateFile($file, $title);
            $message = 'Private file uploaded successfully!';
        }

        return redirect()
            ->route('documents.index')
            ->with('success', $message);
    }


    public function download(int $id)
    {
        $response = $this->documentService->downloadPrivateFile($id);

        if (!$response) {
            return redirect()->route('documents.index')->with('error', 'File not found.');
        }

        return $response;
    }


    public function destroy(int $id): RedirectResponse
    {
        $this->documentService->deleteFile($id);

        return redirect()
            ->route('documents.index')
            ->with('success', 'File deleted successfully!');
    }
}