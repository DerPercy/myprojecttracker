<?php

declare(strict_types=1);
// SPDX-FileCopyrightText: C.Schmidt <github@marchron.de>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\MyProjectTracker\Service;

use Exception;

use OCA\MyProjectTracker\Db\Client;
use OCA\MyProjectTracker\Db\ClientMapper;

use OCP\AppFramework\Db\DoesNotExistException;
use OCP\AppFramework\Db\MultipleObjectsReturnedException;

class ClientService {

    private ClientMapper $mapper;

    public function __construct(ClientMapper $mapper) {
		$this->mapper = $mapper;
	}

	/**
	 * @return list<Note>
	 */
	public function findAll(string $userId): array {
		return $this->mapper->findAll($userId);
	}
	
    public function create(string $title, bool $active, string $userId): Client{
		$client = new Client();
		$client->setTitle($title);
		$client->setActive(($active ? 1 : 0));
		$client->setUserId($userId);
		return $this->mapper->insert($client);
	}

}