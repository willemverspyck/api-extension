<?php

declare(strict_types=1);

namespace Spyck\ApiExtension\Map;

interface DiscriminatorMapInterface extends MapInterface
{
    public function getDiscriminator(): string;

    public function setDiscriminator(string $discriminator): self;
}
