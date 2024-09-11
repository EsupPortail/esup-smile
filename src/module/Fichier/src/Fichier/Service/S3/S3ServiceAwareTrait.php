<?php

namespace Fichier\Service\S3;

use Fichier\Service\S3\S3Service;

trait S3ServiceAwareTrait {

    private S3Service $s3Service;

    public function getS3Service(): S3Service
    {
        return $this->s3Service;
    }

    public function setS3Service($s3Service): S3Service
    {
        $this->s3Service = $s3Service;
        return $this->s3Service;
    }
}