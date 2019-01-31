<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class InvoiceController extends AbstractController
{
    /**
     * @Route("/invoices")
     */
    public function createInvoiceAction()
    {
    }

    /**
     * @Route("/invoices/{id}/pay")
     */
    public function payInvoiceAction()
    {
    }
}
