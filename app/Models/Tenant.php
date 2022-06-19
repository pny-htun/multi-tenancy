<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    /**
     * Change specific customer's(tenant) database
     */
    public function configure()
    {
        config([
            'database.connections.mysql.host' => $this->host,
            'database.connections.mysql.port' => $this->port,
            'database.connections.mysql.username' => $this->user_name,
            'database.connections.mysql.password' => $this->password,
            'database.connections.mysql.database' => $this->db_name,
        ]);

        DB::purge('mysql');

        DB::reconnect('mysql');

        Schema::connection('mysql')->getConnection()->reconnect();

        return $this;
    }

    /**
     * Change service container instance
     */
    public function use()
    {
        app()->forgetInstance('mysql');

        app()->instance('mysql', $this);

        return $this;
    }
}
