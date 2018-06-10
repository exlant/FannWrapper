<?php
declare(strict_types=1);

namespace Database\SQL;

use Doctrine\ORM\Query\SqlWalker;

/**
 * Class MysqlPaginationWalker
 *
 * @package Database\SQL
 */
class MysqlPaginationWalker extends SqlWalker
{
    /**
     * Walks down a SelectClause AST node, thereby generating the appropriate SQL.
     *
     * @param $selectClause
     * @return string The SQL.
     */
    public function walkSelectClause($selectClause)
    {
        $sql = parent::walkSelectClause($selectClause);

        if ($this->getQuery()->getHint('mysqlWalker.sqlCalcFoundRows') === true) {
            if ($selectClause->isDistinct) {
                $sql = \str_replace('SELECT DISTINCT', 'SELECT DISTINCT SQL_CALC_FOUND_ROWS', $sql);
            } else {
                $sql = \str_replace('SELECT', 'SELECT SQL_CALC_FOUND_ROWS', $sql);
            }
        }

        return $sql;
    }
}