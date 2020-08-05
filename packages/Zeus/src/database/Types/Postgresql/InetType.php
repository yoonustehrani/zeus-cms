<?php

namespace Zeus\Database\Types\Postgresql;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Zeus\Database\Types\Type;

class InetType extends Type
{
    const NAME = 'inet';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'inet';
    }
}
