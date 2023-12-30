<?php

declare(strict_types=1);
// SPDX-FileCopyrightText: C.Schmidt <github@marchron.de>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\MyProjectTracker\Migration;

use Closure;
use OCP\DB\ISchemaWrapper;
use OCP\Migration\IOutput;
use OCP\Migration\SimpleMigrationStep;

class Version000001Date20231228000 extends SimpleMigrationStep {

	/**
	 * @param IOutput $output
	 * @param Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
	 * @param array $options
	 * @return null|ISchemaWrapper
	 */
	public function changeSchema(IOutput $output, Closure $schemaClosure, array $options) {
		/** @var ISchemaWrapper $schema */
		$schema = $schemaClosure();

		if (!$schema->hasTable('mypt_clients')) {
			$table = $schema->createTable('mypt_clients');
			$table->addColumn('id', 'integer', [
				'autoincrement' => true,
				'notnull' => true,
			]);
			$table->addColumn('title', 'string', [
				'notnull' => true,
				'length' => 200
			]);
			$table->addColumn('user_id', 'string', [
				'notnull' => true,
				'length' => 200,
			]);

			// Use "integer" instead of "boolean" here for wider database support
			// see: https://docs.nextcloud.com/server/latest/developer_manual/basics/storage/database.html (e.g. PHP casts false to the empty string which fails on PostgreSQL)

			$table->addColumn('active', 'integer', [
				'notnull' => false,
				'default' => 1,
			]);


			$table->setPrimaryKey(['id']);
			$table->addIndex(['user_id'], 'mypt_clients_user_id_index');
		}
		return $schema;
	}
}
