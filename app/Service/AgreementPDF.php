<?php

namespace App\Service;

use App\Models\Agreement;
use App\Models\Delivery;
use App\Models\InventoryMovement;
use Barryvdh\DomPDF\Facade\Pdf;

class AgreementPDF
{
    public static function generatePDF(Agreement $agreement)
    {
        $contract = $agreement->contract;

        $pdf = Pdf::loadView('app.agreement.view', compact('agreement', 'contract'));

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
            }, 'name.pdf');
    }
}