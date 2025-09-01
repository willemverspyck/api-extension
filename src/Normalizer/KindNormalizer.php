<?php

declare(strict_types=1);

namespace Spyck\ApiExtension\Normalizer;

use ReflectionClass;
use Spyck\ApiExtension\Entity\KindInterface;

final class KindNormalizer extends AbstractNormalizer
{
    public function normalize(mixed $data, ?string $format = null, array $context = []): array
    {
        $normalize = $this->normalizer->normalize($data, $format, $context);

        $kind = new ReflectionClass(get_class($data))->getShortName();

        return [
            'kind' => strtolower($kind),
            ...$normalize,
        ];
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof KindInterface;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            KindInterface::class => true,
        ];
    }
}
