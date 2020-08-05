<?php

namespace Zeus\Database;

use Doctrine\DBAL\Schema\SchemaException;
use Doctrine\DBAL\Schema\Table as DoctrineTable;
use Illuminate\Support\Facades\DB;

abstract class Schema
{
    public static function __callStatic($method, $args)
    {
        return static::manager()->$method(...$args);
    }

    public static function manager()
    {
        return DB::connection()->getDoctrineSchemaManager();
    }

    public static function getDatabaseConnection()
    {
        return DB::connection()->getDoctrineConnection();
    }
    
    public static function tableExists($table)
    {
        if (!is_array($table)) {
            $table = [$table];
        }

        return static::manager()->tablesExist($table);
    }

    public static function listTables()
    {
        $tables = [];

        foreach (static::manager()->listTableNames() as $tableName) {
            $tables[$tableName] = static::listTableDetails($tableName);
        }

        return $tables;
    }

    /**
     * @param string $tableName
     *
     * @return \TCG\Voyager\Database\Schema\Table
     */
    public static function listTableDetails($tableName)
    {
        $columns = static::manager()->listTableColumns($tableName);

        $foreignKeys = [];
        if (static::manager()->getDatabasePlatform()->supportsForeignKeyConstraints()) {
            $foreignKeys = static::manager()->listTableForeignKeys($tableName);
        }

        $indexes = static::manager()->listTableIndexes($tableName);
        
        return array($tableName, $columns, $indexes, $foreignKeys, false, []);
        // return new Table($tableName, $columns, $indexes, $foreignKeys, false, []);
    }
    
    public static function listTableColumnNames($tableName)
    {

        $columnNames = [];

        foreach (static::manager()->listTableColumns($tableName) as $column) {
            $columnNames[] = $column->getName();
        }

        return $columnNames;
    }
    
    public static function describeTable($tableName)
    {
        // Type::registerCustomPlatformTypes();

        $table = static::listTableDetails($tableName);
        return $table;
        // return collect($table->columns)->map(function ($column) use ($table) {
        //     $columnArr = Column::toArray($column);

        //     $columnArr['field'] = $columnArr['name'];
        //     $columnArr['type'] = $columnArr['type']['name'];

        //     // Set the indexes and key
        //     $columnArr['indexes'] = [];
        //     $columnArr['key'] = null;
        //     if ($columnArr['indexes'] = $table->getColumnsIndexes($columnArr['name'], true)) {
        //         // Convert indexes to Array
        //         foreach ($columnArr['indexes'] as $name => $index) {
        //             $columnArr['indexes'][$name] = Index::toArray($index);
        //         }

        //         // If there are multiple indexes for the column
        //         // the Key will be one with highest priority
        //         $indexType = array_values($columnArr['indexes'])[0]['type'];
        //         $columnArr['key'] = substr($indexType, 0, 3);
        //     }

        //     return $columnArr;
        // });
    }
}
