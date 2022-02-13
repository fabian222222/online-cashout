<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class GetCurrentUserController extends AbstractController
{
    public function __invoke(){
        return $this->json($this->getUser());
    }
}
