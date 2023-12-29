<?php

declare(strict_types=1);

namespace OCA\MyProjectTracker\Controller;

use OCA\MyProjectTracker\AppInfo\Application;
use OCA\MyProjectTracker\Service\NoteService;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\DataResponse;
use OCP\IRequest;


class MenuController extends Controller {

    use Errors;
    
    public function __construct(IRequest $request,
		NoteService $service,
		?string $userId) {
		parent::__construct(Application::APP_ID, $request);
		#$this->service = $service;
		#$this->userId = $userId;
	}
    /**
	 * @NoAdminRequired
	 */
	public function mainmenu(): DataResponse {
        $cars = array(
            array(
                "label" => "Clients",
                "page" => "crud",
                "options" => array(
                    "url" => array (
                        "entityschema" => "/apps/myprojecttracker/client/schema",
                        "resources" => "/apps/myprojecttracker/client/resources"
                    )

                )
            ),
            array(
                "label" => "Projects"
            )
        );
		return new DataResponse($cars);
	}
}
