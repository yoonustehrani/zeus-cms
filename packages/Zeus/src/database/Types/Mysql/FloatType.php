<?php

namespace Zeus\Database\Types\Mysql;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Zeus\Database\Types\Type;

class FloatType extends Type
{
    const NAME = 'float';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'float';
    }
}
