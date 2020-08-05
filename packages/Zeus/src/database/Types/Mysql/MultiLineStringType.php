<?php

namespace Zeus\Database\Types\Mysql;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Zeus\Database\Types\Type;

class MultiLineStringType extends Type
{
    const NAME = 'multilinestring';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'multilinestring';
    }
}
