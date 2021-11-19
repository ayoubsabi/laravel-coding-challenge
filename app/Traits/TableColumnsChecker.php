<?php

namespace App\Traits;

use Exception;

trait TableColumnsChecker
{
    /**
     * Check if columns exists in the table.
     * @method checkIfColumnsExists(array $inputColumns, array $tableColumns)
     *
     * @param array $inputColumns
     * @param array $tableColumns
     * 
     * @return true
     * 
     * @throws \Exception
     */
    protected function checkIfColumnsExists(array $inputColumns, array $tableColumns): bool
    {
        throw_if(
            ! empty($inputColumns) && $nonExistentColumns = array_diff($inputColumns, $tableColumns),
            new Exception(sprintf("These columns {%s} are not exists in the table", implode(', ', $nonExistentColumns)))
        );

        return true;
    }
}