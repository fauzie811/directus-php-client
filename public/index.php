<?php

require '../autoload.php';

Motekar\Roti::getInstance()
    ->useCache(false)
    ->run('../routes');
