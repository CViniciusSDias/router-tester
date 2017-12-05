<?php
namespace RouterTest\Controller;

use Symfony\Component\HttpFoundation\Response;

class TestController
{
    public function indexAction(int $param): Response
    {
        return new Response("<html><body><p>Teste. <b>$param</b></p></body></html>");
    }
}
