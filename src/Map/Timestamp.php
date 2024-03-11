<?php

namespace Spyck\ApiExtension\Map;

use DateTimeImmutable;
use OpenApi\Attributes as OpenApi;
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Validator\Constraints as Validator;

final class Timestamp
{
    #[OpenApi\QueryParameter(name: 'start', description: 'Timestamp before specified date')]
    #[Serializer\Context(denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
    #[Validator\Regex(pattern: '/^[\d]{4}-[\d]{2}-[\d]{2}$/', message: 'This value is not valid')]
    private ?DateTimeImmutable $start = null;

    #[OpenApi\QueryParameter(name: 'end', description: 'Timestamp after specified date')]
    #[Serializer\Context(denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
    #[Validator\Regex(pattern: '/^[\d]{4}-[\d]{2}-[\d]{2}$/', message: 'This value is not valid')]
    private ?DateTimeImmutable $end = null;

    public function getStart(): ?DateTimeImmutable
    {
        return $this->start;
    }

    public function setStart(?DateTimeImmutable $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?DateTimeImmutable
    {
        return $this->end;
    }

    public function setEnd(?DateTimeImmutable $end): self
    {
        $this->end = $end;

        return $this;
    }
}
