<?php

namespace App\Controller\Admin;

use App\Controller\AppController as ParentController;

class AdminController extends ParentController {

    public function isAuthorized($user) {
        return parent::isAuthorized($user) && $user['isAdmin'];
    }

}