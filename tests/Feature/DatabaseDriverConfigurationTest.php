<?php

namespace Tests\Feature;

use Tests\TestCase;

class DatabaseDriverConfigurationTest extends TestCase
{
    public function test_application_supports_only_mysql_compatible_connections(): void
    {
        $this->assertSame('mysql', config('database.default'));
        $this->assertSame(['mysql', 'mariadb'], array_keys(config('database.connections')));
        $this->assertSame('InnoDB', config('database.connections.mysql.engine'));
        $this->assertSame('InnoDB', config('database.connections.mariadb.engine'));
    }

    public function test_test_environment_uses_an_isolated_mysql_database_and_database_stores(): void
    {
        $this->assertSame('mysql', config('database.default'));
        $this->assertSame('portfolio_test', config('database.connections.mysql.database'));
        $this->assertSame('database', config('session.driver'));
        $this->assertSame('database', config('cache.default'));
        $this->assertSame('database', config('queue.default'));
    }
}
