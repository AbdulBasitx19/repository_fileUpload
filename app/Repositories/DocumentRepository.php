<?php

namespace App\Repositories;
use App\Models\Document;
use App\Interfaces\DocumentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class DocumentRepository implements DocumentRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    protected Document $documentModel;
    public function __construct(Document $documentModel)
    {
        $this->documentModel = $documentModel;
    }

    public function getPublicDocuments(): Collection 
    {
        return $this->documentModel->where('disk', 'public')->latest()->get();
    }

    public function getPrivateDocuments(): Collection 
    {
        return $this->documentModel->where('disk', 'local')->latest()->get();
    }

    public function find(int $id): ?Document 
    {
        return $this->documentModel->find($id);
    }

    public function create(array $data): Document 
    {
        return $this->documentModel::create($data);
    }

    public function delete(int $id): bool 
    {
        $document = $this->documentModel->findOrFail($id);

        Storage::disk($document->disk)->delete($document->file_path);
        return $document->delete();
    }
}
