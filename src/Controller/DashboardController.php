<?php

namespace App\Controller;

use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractRestController
{
    #[Route(path: '/dashboard', name: 'dashboard')]
    #[IsGranted('ROLE_USER')]
    #[Template(template: 'dashboard/index.html.twig')]
    public function index()
    {
        return [];
    }
}
