<?php

declare(strict_types=1);
// SPDX-FileCopyrightText: C.Schmidt <github@marchron.de>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\MyProjectTracker\Tests\Integration\Controller;

use OCA\MyProjectTracker\Controller\ClientController;
use OCA\MyProjectTracker\Db\Client;
use OCA\MyProjectTracker\Db\ClientMapper;

use OCP\AppFramework\App;
use OCP\IRequest;
use PHPUnit\Framework\TestCase;

class ClientIntegrationTest extends TestCase {
	private ClientController $controller;
	private ClientMapper $mapper;
	private string $userId = 'tester';

	public function setUp(): void {
		$app = new App('myprojecttracker');
		$container = $app->getContainer();

		// only replace the user id
		$container->registerService('userId', function () {
			return $this->userId;
		});

		// we do not care about the request but the controller needs it
		$container->registerService(IRequest::class, function () {
			return $this->createMock(IRequest::class);
		});

		$this->controller = $container->get(ClientController::class);
		$this->mapper = $container->get(ClientMapper::class);
	}

	public function testUpdate(): void {
		// create a new client that should be updated
		$client = new Client();
		$client->setTitle('old_title');
		$client->setActive(true);
		$client->setUserId($this->userId);

		$id = $this->mapper->insert($client)->getId();

		// fromRow does not set the fields as updated
		$updatedClient = Client::fromRow([
			'id' => $id,
			'user_id' => $this->userId
		]);
		$updatedClient->setTitle('title');
		$updatedClient->setActive(false);

		$result = $this->controller->update($id, 'title', 'no');

		$this->assertEquals($updatedClient, $result->getData());

		// clean up
		$this->mapper->delete($result->getData());
	}

    public function testDelete(): void {
		// create a new client that should be deleted
		$client = new Client();
		$client->setTitle('old_title');
		$client->setActive(true);
		$client->setUserId($this->userId);

		$id = $this->mapper->insert($client)->getId();

		$result = $this->controller->destroy($id);

		$this->assertEquals($id, $result->getData()->getId());

		// Check, if deleted
        $this->expectException(ClientNotFoundException::class);
        $this->controller->show($id);
    }
}
