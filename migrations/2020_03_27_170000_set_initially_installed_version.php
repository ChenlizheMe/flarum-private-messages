<?php

Use Illuminate\Database\Schema\Builder;

return [
    'up' => function (Builder $schema) {
        $connection = $schema->getConnection();
        $initialInstalledVersion = $schema->hasColumn('users', 'unread_messages') ? '1.4.0' : '1.5.3';

        $table = $connection->getTablePrefix() . 'settings';

        $connection->insert('INSERT INTO `' . $table . '` (`key`, `value`) VALUES(\'chenlizheme-private-messages.initial_installed_version\', ?)', [$initialInstalledVersion]);
    },
    'down' => function (Builder $schema) {
        $connection = $schema->getConnection();

        $table = $connection->getTablePrefix() . 'settings';

        $connection->insert('DELETE FROM `' . $table . '` WHERE `key` = \'chenlizheme-private-messages.initial_installed_version\'');
    }
];