<?php

namespace Fichier\Service\S3;

use Doctrine\ORM\NonUniqueResultException;
use UnicaenApp\Exception\RuntimeException;
use Aws\S3\S3Client;

class S3Service {

    protected string $defaultBucket;
    protected S3Client $client;
    public function __construct()
    {
        $this->defaultBucket = $_ENV['AWS_BUCKET_NAME'];
        $this->client = new S3Client([
            'version' => 'latest',
            'region' => $_ENV['AWS_DEFAULT_REGION'],
            'endpoint' => $_ENV['AWS_ENDPOINT'],
            'use_path_style_endpoint' => true,
            'credentials' => [
                'key' => $_ENV['AWS_ACCESS_KEY_ID'],
                'secret' => $_ENV['AWS_SECRET_ACCESS_KEY'],
            ],
        ]);
    }
    public function getS3Client()
    {
        return $this->client;
    }

    public function createBucket(string $bucketName): \Aws\Result
    {
        $result = $this->client->createBucket([
            'Bucket' => $bucketName,
            'CreateBucketConfiguration' => [
                'LocationConstraint' => $_ENV['AWS_DEFAULT_REGION']
            ]
        ]);
        return $result;
    }

    public function listBuckets(): \Aws\Result
    {
        $result = $this->client->listBuckets();
        return $result;
    }

    public function getBucketContent(?string $path = ''): \Aws\Result
    {
        $result = $this->client->listObjects([
            'Bucket' => $this->defaultBucket,
            'Prefix' => $path,
        ]);

        return $result;
    }

    public function addFileToBucket(string $key, string $sourceFilePath): \Aws\Result
    {
        try {
            // Validate the source file path
            if (!file_exists($sourceFilePath)) {
                throw new \RuntimeException("Source file does not exist: " . $sourceFilePath);
            }

            return $this->client->putObject([
                'Bucket' => $this->defaultBucket,
                'Key' => $key,
                'SourceFile' => $sourceFilePath,
            ]);
        } catch (\Exception $e) {
            throw new RuntimeException("Un problème s'est produit lors de l'ajout d'un fichier dans le bucket S3. : ".$e->getMessage(), $e->getCode(), $e);
        }
    }

    public function getObject(string $key): \Aws\Result
    {
        $result = $this->client->getObject([
            'Bucket' => $this->defaultBucket,
            'Key' => $key,
        ]);
        return $result;
    }

    public function getFileDownloadUrl(string $key): string
    {
        $cmd = $this->client->getCommand('GetObject', [
            'Bucket' => $this->defaultBucket,
            'Key' => $key
        ]);

        $request = $this->client->createPresignedRequest($cmd, '+20 minutes');

        // Get the pre-signed URL
        $presignedUrl = (string)$request->getUri();

        return $presignedUrl;
    }

    public function removeFileFromBucket(string $key): \Aws\Result
    {
        $result = $this->client->deleteObject([
            'Bucket' => $this->defaultBucket,
            'Key' => $key,
        ]);
        return $result;
    }
}