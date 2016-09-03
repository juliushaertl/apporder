<?php

namespace OCA\AppOrder\Controller;

use \OCP\AppFramework\Controller;
use \OCP\AppFramework\Http\TemplateResponse;
use \OCP\IRequest;
use \OCP\INavigationManager;
use \OCA\AppOrder\Service\ConfigService;
use \OCA\AppOrder\Util;

class SettingsController extends Controller {

    private $userId;
    private $appConfig;
    private $navigationManager;
	private $util;

    public function __construct($appName, IRequest $request, ConfigService $appConfig, INavigationManager $navigationManager, Util $util, $userId) {
        parent::__construct($appName, $request);
        $this->userId = $userId;
        $this->appConfig = $appConfig;
        $this->navigationManager = $navigationManager;
		$this->util = $util;
    }

	/**
	 * Admin: render admin page
	 * FIXME: Move to dedicated class
	 * @return TemplateResponse
	 */
    public function adminIndex() {
		// Private API call
        $navigation = $this->navigationManager->getAll();
        $order = json_decode($this->appConfig->getAppValue('order'));
        $nav = $this->util->matchOrder($navigation, $order);
        return new TemplateResponse(
            $this->appName, 
            'admin',
            ["nav" => $nav],
            'blank'
        );
    }

	/**
	 * Admin: save default order
	 * @param $order
	 * @return array
	 */
	public function saveDefaultOrder($order) {
		if (!is_null($order)) {
			$this->appConfig->setAppValue('order', $order);
		}
		return array('status' => 'success', 'order' => $order);
	}

    /**
     * @NoAdminRequired
     */
    public function getOrder() {
        $order = $this->util->getAppOrder();
        return array('status' => 'success', 'order' => $order);
    }

	/**
	 * @NoAdminRequired
	 * @param $order string
	 * @return array response
	 */
    public function savePersonal($order) {
        $this->appConfig->setUserValue('order', $this->userId, $order);
        $response = array(
            'status' => 'success',
            'data' => array('message'=> 'User order saved successfully.'),
            'order' => $order
        );
        return $response;
    }


}
