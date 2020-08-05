<?php

namespace Zeus\Database\Types\Postgresql;

use Zeus\Database\Types\Common\CharType;

class CharacterType extends CharType
{
    const NAME = 'character';
    const DBTYPE = 'bpchar';
}
