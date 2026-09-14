<?php

namespace App\Services;

use App\Interfaces\DocumentRepositoryInterface;
use App\Models\Document;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DocumentService
{
    /**
     * Create a new class instance.
     */
    protected DocumentRepositoryInterface $documentRepository;

    public function __construct(DocumentRepositoryInterface $documentRepository)
    {
        $this->documentRepository = $documentRepository;
    }

    public function uploadPublicFile(UploadedFile $file, string $title): Document
    {
        $uniqueName = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('documents', $uniqueName, 'public');

         $data = [
            'title' => $title,
            'original_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'disk' => 'public',
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
        ];
    
        return $this->documentRepository->create($data);
    }

    public function uploadPrivateFile(UploadedFile $file, string $title): Document
    {
        $uniqueName = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('private_documents', $uniqueName, 'local');

        $data = [
            'title' => $title,
            'original_name' => $file->getClientOriginalName(),
            'file_path' => $path,
            'disk' => 'local',
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
        ];

        return $this->documentRepository->create($data);
    }

    public function getPublicFiles(): Collection
    {
        return $this->documentRepository->getPublicDocuments();
    }

    public function getPrivateFiles(): Collection
    {
        return $this->documentRepository->getPrivateDocuments();
    }

    public function downloadPrivateFile(int $id)
    {
        $document = $this->documentRepository->find($id);
        if (!$document) {
            return null; 
        }

        $fullPath = Storage::disk($document->disk)->path($document->file_path);
        return response()->download($fullPath, $document->original_name);
    }

    public function deleteFile(int $id): bool
    {
        return $this->documentRepository->delete($id);
    }
}
