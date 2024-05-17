<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class LaporanKeuangan extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->module = 'LaporanKeuangan';
    }

    /**
     * This is default routing method
     * It routes to default listing page
     */
    public function index()
    {
        $this->loadViews("laporan-keuangan/list", $this->global, NULL, NULL);
    }

    public function getList()
    {

    }
}


?>