<?php

namespace Application\Service\Document;

trait DocumentServiceAwareTrait {
    private DocumentService $documentService;

    /**
     * @return DocumentService
     */
    public function getDocumentService(): DocumentService
    {
        return $this->documentService;
    }

    /**
     * @param DocumentService $documentService
     *
     * @return DocumentService
     */
    public function setDocumentService(DocumentService $documentService
    ): DocumentService {
        $this->documentService = $documentService;
        return $this->documentService;
    }
}