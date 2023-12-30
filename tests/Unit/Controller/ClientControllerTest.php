<?php

declare(strict_types=1);
// SPDX-FileCopyrightText: C.Schmidt <github@marchron.de>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\MyProjectTracker\Tests\Unit\Controller;

use OCA\MyProjectTracker\Controller\ClientController;

//use OCA\MyProjectTracker\Service\NoteNotFound;
use OCA\MyProjectTracker\Service\ClientService;
use OCA\MyProjectTracker\Db\Client;

use OCP\AppFramework\Http;
use OCP\IRequest;
use PHPUnit\Framework\TestCase;

class ClientControllerTest extends TestCase {
	protected ClientController $controller;
	protected string $userId = 'john';
	protected $service;
	protected $request;

	public function setUp(): void {
		$this->request = $this->getMockBuilder(IRequest::class)->getMock();
		$this->service = $this->getMockBuilder(ClientService::class)
			->disableOriginalConstructor()
			->getMock();
		$this->controller = new ClientController($this->request, $this->service, $this->userId);
	}

	public function testCreateActive(): void {
		$client = new Client();

        // "Active" mapping: yes => true
		$this->service->expects($this->once())
			->method('create')
			->with(
				$this->equalTo('title'),
				$this->equalTo(true),
				$this->equalTo($this->userId))
			->will($this->returnValue($client));

		$result = $this->controller->create('title','yes');

		$this->assertEquals($client, $result->getData());

    }

    public function testCreateInactive(): void {
		$client = new Client();

        
        // "Active" mapping: no => false
        $this->service->expects($this->once())
			->method('create')
			->with(
				$this->equalTo('title'),
				$this->equalTo(false),
				$this->equalTo($this->userId))
			->will($this->returnValue($client));

		$result = $this->controller->create('title','no');

		$this->assertEquals($client, $result->getData());
	}


	/*public function testUpdateNotFound(): void {
		// test the correct status code if no note is found
		$this->service->expects($this->once())
			->method('update')
			->will($this->throwException(new NoteNotFound()));

		$result = $this->controller->update(3, 'title', 'content');

		$this->assertEquals(Http::STATUS_NOT_FOUND, $result->getStatus());
	}*/
}
