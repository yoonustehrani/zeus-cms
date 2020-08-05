<?php

namespace Zeus\Database\Types\Mysql;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Zeus\Database\Types\Type;

class TinyBlobType extends Type
{
    const NAME = 'tinyblob';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'tinyblob';
    }
}
