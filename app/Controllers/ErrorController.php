<?php

namespace App\Controllers;

use App\Controllers\CoreController;

class ErrorController extends CoreController
{
    public function err404()
    {
        header("HTTP/1.1 404 Not Found");
        $this->show('error/err404');
    }

    public function err403()
    {
        header('HTTP/1.0 403 Forbidden');
        $this->show('error/err403');
    }
}
