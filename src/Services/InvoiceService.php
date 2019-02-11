<?php
/**
 * Created by PhpStorm.
 * User: madman
 * Date: 31/01/19
 * Time: 17:38.
 */

namespace App\Services;

use App\Entity\Invoice;
use Doctrine\Common\Persistence\ManagerRegistry;

class InvoiceService
{
    /**
     * @var StripeService
     */
    private $stripeService;

    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    public function __construct(StripeService $stripeService, ManagerRegistry $doctrine)
    {
        $this->stripeService = $stripeService;
        $this->doctrine = $doctrine;
    }

    public function payInvoice(Invoice $invoice)
    {
        $this->stripeService->createChargeForInvoice($invoice);

        $this->doctrine->getManager()->flush();

        return $invoice;
    }
}
