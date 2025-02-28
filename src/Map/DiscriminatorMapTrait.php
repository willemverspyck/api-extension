<?php

declare(strict_types=1);

namespace Spyck\ApiExtension\Map;

use OpenApi\Attributes as OpenApi;
use Symfony\Component\Validator\Constraints as Validator;

trait DiscriminatorMapTrait
{
    #[OpenApi\QueryParameter(name: 'discriminator', description: 'Discriminator')]
    #[Validator\NotBlank]
    private ?string $discriminator = null;

    public function getDiscriminator(): string
    {
        return $this->discriminator;
    }

    public function setDiscriminator(string $discriminator): self
    {
        $this->discriminator = $discriminator;

        return $this;
    }
}
