<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Services\InvoiceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class InvoiceController extends AbstractController
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var InvoiceService
     */
    private $invoiceService;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @Route("/invoices")
     */
    public function createInvoiceAction(Request $request)
    {
        $invoice = $this->serializer->deserialize($request->getContent(), Invoice::class, 'json');

        $em = $this->getDoctrine()->getManager();
        $em->persist($invoice);
        $em->flush();

        return $this->json(['invoice' => $invoice]);
    }

    /**
     * @Route("/invoices/{invoice}/pay")
     */
    public function payInvoiceAction(Request $request, Invoice $invoice)
    {
        $this->invoiceService->payInvoice($invoice);
    }
}
