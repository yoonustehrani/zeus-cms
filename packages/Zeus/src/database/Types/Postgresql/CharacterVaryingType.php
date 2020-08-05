<?php

namespace Zeus\Database\Types\Postgresql;

use Zeus\Database\Types\Common\VarCharType;

class CharacterVaryingType extends VarCharType
{
    const NAME = 'character varying';
    const DBTYPE = 'varchar';
}
