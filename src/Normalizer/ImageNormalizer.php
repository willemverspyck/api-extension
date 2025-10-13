<?php

declare(strict_types=1);

namespace Spyck\ApiExtension\Normalizer;

use ArrayObject;
use LogicException;
use Spyck\ApiExtension\Model\Image;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

final class ImageNormalizer extends AbstractNormalizer
{
    public function __construct(private readonly ?UploaderHelper $uploaderHelper = null)
    {
    }

    /**
     * @throws InvalidArgumentException
     * @throws LogicException
     */
    public function normalize(mixed $data, ?string $format = null, array $context = []): array|string|int|float|bool|ArrayObject|null
    {
        if (false === $data instanceof Image) {
            throw new InvalidArgumentException(sprintf('Object must be instance of "%s"', Image::class));
        }

        if (null === $this->uploaderHelper) {
            throw new LogicException('VichUploaderBundle is required');
        }

        return $this->uploaderHelper->asset($data->getObject(), $data->getField());
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Image;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Image::class => true,
        ];
    }
}
