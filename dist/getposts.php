<?php

/**
 * This is the client facing interface for getting pages. This should be considered the 'API' for
 * all the client-side functionality that we're including.
 */
require_once('../Application/GetPostsByPage.php');

$posts = new Application\GetPostsByPage();
$posts->getPostsByPage();
$posts->doResponse();