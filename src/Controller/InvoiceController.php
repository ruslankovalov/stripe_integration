<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Services\InvoiceService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api")
 */
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

    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(SerializerInterface $serializer, InvoiceService $invoiceService, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->invoiceService = $invoiceService;
        $this->validator = $validator;
    }

    /**
     * @Route("/invoices", methods={"POST"})
     */
    public function createInvoiceAction(Request $request)
    {
        $invoice = $this->serializer->deserialize($request->getContent(), Invoice::class, 'json');

        $violations = $this->validator->validate($invoice);
        if ($violations->count()) {
            throw new BadRequestHttpException('Invalid invoice data.');
        }

        $this->getUser()->addInvoice($invoice);

        $em = $this->getDoctrine()->getManager();
        $em->persist($invoice);
        $em->flush();

        return $this->json(['invoice' => $invoice]);
    }

    /**
     * @Route("/invoices/{invoice}/pay", methods={"POST"})
     */
    public function payInvoiceAction(Invoice $invoice)
    {
        $this->invoiceService->payInvoice($invoice);

        return $this->json(['invoice' => $invoice]);
    }
}
