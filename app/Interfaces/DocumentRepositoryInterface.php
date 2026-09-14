<?php

namespace App\Interfaces;
use App\Models\Document;
use Illuminate\Database\Eloquent\Collection;


interface DocumentRepositoryInterface
{
    //
    public function getPublicDocuments(): Collection;
    public function getPrivateDocuments(): Collection;
    public function find(int $id): ?Document;
    public function create(array $data): Document;
    public function delete(int $id): bool;
}
