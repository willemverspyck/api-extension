<?php

declare(strict_types=1);

namespace Spyck\ApiExtension\Normalizer;

use ArrayObject;
use Liip\ImagineBundle\Service\FilterService;
use LogicException;
use Spyck\ApiExtension\Model\Image;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

final class ImageNormalizer extends AbstractNormalizer
{
    public function __construct(#[Autowire(service: 'liip_imagine.service.filter')] private ?FilterService $filterService = null, private readonly ?UploaderHelper $uploaderHelper = null)
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

        $asset = $this->uploaderHelper->asset($data->getObject(), $data->getField());

        if (null === $data->getFilter()) {
            return $asset;
        }

        if (null === $this->filterService) {
            throw new LogicException('LiipImagineBundle is required');
        }

        return $this->filterService->getUrlOfFilteredImage(path: $asset, filter: $data->getFilter(), webpSupported: true);
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
