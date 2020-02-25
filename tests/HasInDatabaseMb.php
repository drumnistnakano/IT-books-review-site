<?php

namespace Tests;

use Illuminate\Foundation\Testing\Constraints\HasInDatabase;

class HasInDatabaseMb extends HasInDatabase
{
    /**
     * @see github.com/laravel/framework/blob/5.8/src/Illuminate/Foundation/Testing/Constraints/HasInDatabase.php#L66
     */
    protected function getAdditionalInfo($table)
    {
        $results = $this->database->table($table)->get();

        if ($results->isEmpty()) {
            return 'The table is empty';
        }

        $description = 'Found: '.json_encode($results->take($this->show), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        if ($results->count() > $this->show) {
            $description .= sprintf(' and %s others', $results->count() - $this->show);
        }

        return $description;
    }

    /**
     * @see github.com/laravel/framework/blob/5.8/src/Illuminate/Foundation/Testing/Constraints/HasInDatabase.php#L84
     */
    public function toString($options = 0): string
    {
        return json_encode($this->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}