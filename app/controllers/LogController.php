<?php


class LogController extends BaseController {

    private $userModel;

    public function __construct() {
        parent::__construct();
        $this->userModel = new User($this->db);
    }

    /**
     * Display activity logs
     */
    public function index() {
        $this->requireRole('admin');

        $logs = $this->userModel->getRecentActivities(100);
        $this->view('logs/index', ['logs' => $logs]);
    }
}
?>