<?php

namespace Zeus\Database\Types\Mysql;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Zeus\Database\Types\Type;

class MediumBlobType extends Type
{
    const NAME = 'mediumblob';

    public function getSQLDeclaration(array $field, AbstractPlatform $platform)
    {
        return 'mediumblob';
    }
}
