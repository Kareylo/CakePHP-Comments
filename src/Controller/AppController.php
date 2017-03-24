<?php
namespace Kareylo\Comments\Controller;

use App\Controller\AppController as BaseController;

class AppController extends BaseController
{
    /**
     * Setup AppController for the plugin
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Flash');
    }
}
