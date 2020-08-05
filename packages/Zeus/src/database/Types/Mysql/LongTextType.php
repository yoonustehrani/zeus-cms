<?php

namespace Zeus\Database\Types\Mysql;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Zeus\Database\Types\Type;

class LongTextType extends Type
{
    const NAME = 'longtext';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'longtext';
    }
}
