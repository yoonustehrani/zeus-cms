<?php

namespace Zeus\Database\Types\Mysql;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Zeus\Database\Types\Type;

class BlobType extends Type
{
    const NAME = 'blob';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'blob';
    }
}
