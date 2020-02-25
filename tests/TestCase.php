<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    
    /**
     * @see github.com/laravel/framework/blob/5.8/src/Illuminate/Foundation/Testing/Concerns/InteractsWithDatabase.php#L21
     */
    protected function assertDatabaseHas($table, array $data, $connection = null)
    {
        $this->assertThat(
            $table,
            new HasInDatabaseMb($this->getConnection($connection), $data)
        );

        return $this;
    }
}
