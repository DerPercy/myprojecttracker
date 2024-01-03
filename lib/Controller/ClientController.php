<?php

declare(strict_types=1);

namespace OCA\MyProjectTracker\Controller;

use OCA\MyProjectTracker\AppInfo\Application;
use OCA\MyProjectTracker\Service\ClientService;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\DataResponse;
use OCP\IRequest;


class ClientController extends Controller {
    private ClientService $service;
	private ?string $userId;

    use Errors;
    
    public function __construct(IRequest $request,
		ClientService $service,
		?string $userId) {
		parent::__construct(Application::APP_ID, $request);
		$this->service = $service;
		$this->userId = $userId;
	}

    /**
	 * @NoAdminRequired
	 */
	public function index(): DataResponse {
		return new DataResponse($this->service->findAll($this->userId));
    }

    /**
	 * @NoAdminRequired
	 */
	public function show(int $id): DataResponse {
		return $this->handleNotFound(function () use ($id) {
			return $this->service->find($id, $this->userId);
		});
	}

    /**
	 * @NoAdminRequired
	 */
	public function create(string $title, string $active): DataResponse {
        $result = $this->service->create($title, (bool)(strcmp($active,"yes") === 0),$this->userId);
		return new DataResponse($result);
	}

    /**
	 * @NoAdminRequired
	 */
	public function update(int $id, string $title, string $active): DataResponse {
        return $this->handleNotFound(function () use ($id, $title, $active) {
            return $this->service->update($id, $title, (bool)(strcmp($active,"yes") === 0), $this->userId);
        });
    }

    /**
    * @NoAdminRequired
    */
    public function destroy(int $id): DataResponse {
        return $this->handleNotFound(function () use ($id) {
            return $this->service->delete($id, $this->userId);
        });
    }

     /**
	 * @NoAdminRequired
	 */
	public function entityinfo(): DataResponse {
        $info = array(
            "attributes" => array(
                array(
                    "id" => "title",
                    "label" => "Titel"
                ),
                array(
                    "id" => "active",
                    "label" => "Aktiv"
                )
            )
        );

        return new DataResponse($info);
    }

    /**
	 * @NoAdminRequired
	 */
	public function schema(): DataResponse {
        $schema = array(
            array(
                "label" => "Titel",
                "type" => "text",
                "name" => "title",
                "validation" => "required" 
            ),

            array(
                "name" => "active",
                "label" => "Aktiv",
                "type" => "radio",
                "value" => "yes",
                "options" => array(
                    array(
                        "value" => "yes",
                        "label" => "Ja"
                    ),
                    array(
                        "value" => "no",
                        "label" => "Nein"
                    )
                )
            ),
            array(
                "type" => "submit",
                "label" => "Speichern"
            )
        );
        //https://vueformulate.com/guide/forms/generating-forms/#schemas
        /*{
            "type": 'password',
            "name": 'password',
            "label": 'Enter a new password',
            "validation": 'required'
      },
      {
          "type": 'submit',
          "label": 'Change password'
      }*/
		return new DataResponse($schema);
	}
}
