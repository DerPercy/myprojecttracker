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
	 * @return list<Client>
	 */
	public function findAll(string $userId): array {
		return $this->mapper->findAll($userId);
	}

	public function find(int $id, string $userId): Client {
		try {
			return $this->mapper->find($id, $userId);
			// in order to be able to plug in different storage backends like files
			// for instance it is a good idea to turn storage related exceptions
			// into service related exceptions so controllers and service users
			// have to deal with only one type of exception
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}
	
    public function create(string $title, bool $active, string $userId): Client{
		$client = new Client();
		$client->setTitle($title);
		$client->setActive(($active ? 1 : 0));
		$client->setUserId($userId);
		return $this->mapper->insert($client);
	}

	public function update(int $id, string $title, bool $active, string $userId): Client {
		try {
			$client = $this->mapper->find($id, $userId);
			$client->setTitle($title);
			$client->setActive(($active ? 1 : 0));
			return $this->mapper->update($client);
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}

	public function delete(int $id, string $userId): Client {
		try {
			$client = $this->mapper->find($id, $userId);
			$this->mapper->delete($client);
			return $client;
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}

	/**
	 * @return never
	 */
	private function handleException(Exception $e) {
		if ($e instanceof DoesNotExistException ||
			$e instanceof MultipleObjectsReturnedException) {
			throw new ClientNotFoundException($e->getMessage());
		} else {
			throw $e;
		}
	}

}