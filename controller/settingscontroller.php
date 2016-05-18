<?php

namespace OCA\AppOrder\Controller;

use \OCP\AppFramework\Controller;
use \OCP\AppFramework\Http\TemplateResponse;
use \OCP\IRequest;
use \OCP\INavigationManager;
use \OCA\AppOrder\Service\ConfigService;

class SettingsController extends Controller{

    private $userId;
    private $l10n;
    private $appConfig;
    private $navigationManager;

    public function __construct($appName, IRequest $request, ConfigService $appConfig, INavigationManager $navigationManager, $userId){
        parent::__construct($appName, $request);
        $this->userId = $userId;
        $this->appConfig = $appConfig;
        $this->navigationManager = $navigationManager;
    }

    public function adminIndex(){
        return new TemplateResponse(
            $this->appName, 
            'admin',
            ["nav" => $this->navigationManager->getAll()],
            'blank'
        );
    }

    /**
     * @NoAdminRequired
     */
    public function getOrder(){
        $order_user = $this->appConfig->getUserValue('order', $this->userId);
        $order_default = $this->appConfig->getAppValue('order');
        if ($order_user !== null && $order_user !== "")
            $order = $order_user;
        else
            $order = $order_default;
        return array('status' => 'success', 'order' => $order);
    }

    /**
     * @NoAdminRequired
     */
    public function savePersonal($order){
        $this->appConfig->setUserValue('order', $this->userId, $order);
        $response = array(
            'status' => 'success',
            'data' => array('message'=> $this->l10n->t('User order saved successfully.')),
            'order' => $order
        );
        return $response;
    }

    public function saveDefaultOrder($order){
        if (!is_null($order)){
            $this->appConfig->setAppValue('order',$order);
        }
        return array('status' => 'success', 'order' => $order);
    }
}
