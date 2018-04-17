<?php

namespace Hoyvoy\CrossDatabase\Query\Grammars;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Grammars\PostgresGrammar as IlluminatePostgresGrammar;

class PostgresGrammar extends IlluminatePostgresGrammar
{
    /**
     * Compile the "from" portion of the query.
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param string                             $table
     *
     * @return string
     */
    protected function compileFrom(Builder $query, $table)
    {
        // Check for cross database query to attach database name
        if (strpos($table, '<-->') !== false) {
            list($prefix, $table, $database) = explode('<-->', $table);
            $tablePrefixed = $this->wrap($prefix.$table, true);
            return 'from '.$this->wrap($database).'.'.$tablePrefixed.' as '.$this->wrap($table);
        }

        return 'from '.$this->wrapTable($table);
    }
}
