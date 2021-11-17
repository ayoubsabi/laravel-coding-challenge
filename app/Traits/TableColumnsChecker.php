<?php

namespace App\Traits;

use Exception;

trait TableColumnsChecker
{
    /**
     * Check if fields exists in the table.
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
        if (! empty($inputColumns) && $nonExistentColumns = array_diff($inputColumns, $tableColumns)) {
            throw new Exception(sprintf("These columns {%s} are not exists in the table", implode(', ', $nonExistentColumns)));
        }

        return true;
    }
}