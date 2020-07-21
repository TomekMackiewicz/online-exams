<?php

namespace App\Serializer;

use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ExceptionNormalizer implements NormalizerInterface
{
    public function normalize($exception, string $format = null, array $context = [])
    {
        return [
            'content' => 'Error',
            'exception'=> [
                'message' => $exception->getMessage(),
                'code' => $exception->getStatusCode(),
                'format' => $format,
                'context' => $context
            ],
        ];
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $format === 'json' && $data instanceof FlattenException;
    }
}