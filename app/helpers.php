<?php

use App\Libs\Directus;

function directus(): Directus
{
    return Directus::getInstance();
}

function get_header()
{
    include '../views/header.php';
}

function get_footer()
{
    include '../views/footer.php';
}
