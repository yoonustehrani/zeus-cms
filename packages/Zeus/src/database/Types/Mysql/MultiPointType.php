<?php

namespace Zeus\Database\Types\Mysql;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Zeus\Database\Types\Type;

class MultiPointType extends Type
{
    const NAME = 'multipoint';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'multipoint';
    }
}
