<?php

class HomeController extends BaseController {

    /**
     * Display homepage
     */
    public function index() {
        // If authenticated, redirect to dashboard
        if ($this->isAuthenticated()) {
            $this->redirect('dashboard');
        }

        // Otherwise show public homepage or redirect to login
        $this->redirect('login');
    }
}
?>