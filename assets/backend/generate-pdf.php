<?php
require_once('../../FPDF/fpdf.php');

// Combined PDF class for both Purchase Order and Claim Slip
class CombinedPDF extends FPDF
{
    private $claimID;
    private $orderID;
    private $date;

    // Constructor to initialize orderID, claimID, and date for the slips
    function __construct($claimID, $orderID, $date)
    {
        parent::__construct();
        $this->claimID = $claimID;
        $this->orderID = $orderID;
        $this->date = $date;
    }

    // Shared Header Layout for both Order Slip and Claim Slip
    function HeaderLayout($title, $order_number, $date)
    {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(120, 10, 'Marcomedia Products and Services', 0, 0, 'L');
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(70, 10, $title, 0, 1, 'R');
        $this->SetFont('Arial', '', 10);
        $this->SetFillColor(34, 123, 148);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(120, 6, '', 0);
        $this->Cell(35, 6, 'Order Number', 1, 0, 'C', true);
        $this->Cell(35, 6, 'DATE', 1, 1, 'C', true);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(120, 6, '', 0);
        $this->Cell(35, 6, $order_number, 1, 0, 'C');
        $this->Cell(35, 6, $date, 1, 1, 'C');
        $this->Ln(10);
    }

    function PurchaseOrderHeader()
    {
        $this->HeaderLayout('PURCHASE ORDER', $this->orderID, $this->date);
    }

    function CustomerSection($name, $company, $address, $phone, $email)
    {
        $this->SetFillColor(34, 123, 148);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(190, 7, 'CUSTOMER DETAILS', 1, 1, 'C', true);
        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(47.5, 6, 'NAME', 1);
        $this->Cell(142.5, 6, $name, 1, 1);
        $this->Cell(47.5, 6, 'COMPANY NAME', 1);
        $this->Cell(142.5, 6, $company, 1, 1);
        $this->Cell(47.5, 6, 'ADDRESS', 1);
        $this->Cell(142.5, 6, $address, 1, 1);
        $this->Cell(47.5, 6, 'PHONE', 1);
        $this->Cell(142.5, 6, $phone, 1, 1);
        $this->Cell(47.5, 6, 'EMAIL ADDRESS', 1);
        $this->Cell(142.5, 6, $email, 1, 1);
        $this->Ln(5);
    }

    function ShippingSection()
    {
        $this->SetFillColor(34, 123, 148);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(95, 7, 'SHIPPING TERMS', 1, 0, 'C', true);
        $this->Cell(95, 7, 'SHIPPING METHOD', 1, 1, 'C', true);
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', '', 10);
        $this->Cell(95, 7, 'Freight on Board', 1);
        $this->Cell(95, 7, 'Air & Land', 1, 1);
    }

    function ProductTable($products)
    {
        $this->SetFillColor(34, 123, 148);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(30, 7, 'Product ID', 1, 0, 'C', true);
        $this->Cell(80, 7, 'Product Description', 1, 0, 'C', true);
        $this->Cell(20, 7, 'Quantity', 1, 0, 'C', true);
        $this->Cell(30, 7, 'Unit Price', 1, 0, 'C', true);
        $this->Cell(30, 7, 'Amount', 1, 1, 'C', true);

        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0, 0, 0);

        $subtotal = 0;
        foreach ($products as $product) {
            $this->Cell(30, 7, $product['product_id'], 1);
            $this->Cell(80, 7, $product['product_name'], 1);
            $this->Cell(20, 7, $product['quantity'], 1, 0, 'R');
            $this->Cell(30, 7, number_format($product['price'], 2), 1, 0, 'R');
            $this->Cell(30, 7, number_format($product['total'], 2), 1, 1, 'R');

            $subtotal += $product['total'];
        }

        $this->Ln(5);

        return $subtotal;
    }

    function SummarySection($subtotal, $vat_percentage, $shipping, $total_with_vat, $discount_percentage, $downpayment, $balance)
    {
        $this->SetXY(10, $this->GetY());
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(34, 123, 148);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(95, 7, 'NOTE', 1, 0, 'L', true);
        $this->Ln();
        $this->SetFont('Arial', 'I', 10);
        $this->SetTextColor(0, 0, 0);
        $this->MultiCell(95, 7, "Payment shall be 30 days upon receipt of the items above.", 1, 'L');

        $this->SetXY(105, $this->GetY() - 14);
        $this->SetFont('Arial', 'B');

        $this->Cell(50, 7, 'Subtotal', 1);
        $this->Cell(45, 7, number_format($subtotal, 2), 1, 1, 'R');

        $this->SetXY(105, $this->GetY());
        $this->Cell(50, 7, 'Discount (%)', 1);
        $this->Cell(45, 7, number_format($discount_percentage, 2) . '%', 1, 1, 'R');

        $this->SetXY(105, $this->GetY());
        $this->Cell(50, 7, 'VAT', 1);
        $this->Cell(45, 7, '(' . number_format($vat_percentage, 2) . '%)', 1, 1, 'R');

        $this->SetXY(105, $this->GetY());
        $this->Cell(50, 7, 'Shipping', 1);
        $this->Cell(45, 7, number_format($shipping, 2), 1, 1, 'R');

        $this->SetXY(105, $this->GetY());
        $this->SetFillColor(211, 211, 211);
        $this->Cell(50, 8, 'TOTAL', 1, 0, 'C', true);
        $this->Cell(45, 8, number_format($total_with_vat, 2), 1, 1, 'R', true);

        $this->SetXY(105, $this->GetY());
        $this->SetFillColor(255, 255, 255);
        $this->Cell(50, 7, 'Downpayment', 1);
        $this->Cell(45, 7, number_format($downpayment, 2), 1, 1, 'R');

        $this->SetXY(105, $this->GetY());
        $this->SetFillColor(173, 216, 230);
        $this->Cell(50, 7, 'Balance', 1, 0, 'C', true);
        $this->Cell(45, 7, number_format($balance, 2), 1, 1, 'R', true);

        $this->Ln(5);
    }

    function ClaimSlipHeader()
    {
        $this->HeaderLayout('CLAIM SLIP', $this->claimID, $this->date);
    }

    function ClaimItemsTable($items, $product_total, $vat_total, $total_with_vat, $vat_percentage)
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Items Claimed', 0, 1, 'L');
        $this->SetFillColor(34, 123, 148);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(30, 7, 'Product ID', 1, 0, 'C', true);
        $this->Cell(100, 7, 'Item Description', 1, 0, 'C', true);
        $this->Cell(30, 7, 'Quantity', 1, 0, 'R', true);
        $this->Cell(30, 7, 'Unit Price', 1, 1, 'R', true);

        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0, 0, 0);
        $product_total = 0;

        foreach ($items as $item) {
            $this->Cell(30, 7, $item['product_id'], 1);
            $this->Cell(100, 7, $item['product_name'], 1);
            $this->Cell(30, 7, $item['quantity'], 1, 0, 'R');
            $this->Cell(30, 7, number_format($item['price'], 2), 1, 1, 'R');


            $product_total += $item['price'] * $item['quantity'];
        }

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(160, 7, 'Product Total', 1, 0, 'R');
        $this->Cell(30, 7, number_format($product_total, 2), 1, 1, 'R');

        $this->Cell(160, 7, 'VAT (' . number_format($vat_percentage, 2) . '%)', 1, 0, 'R');
        $this->Cell(30, 7, number_format($vat_total, 2), 1, 1, 'R');

        $this->Cell(160, 7, 'Total Amount with Tax', 1, 0, 'R');
        $this->Cell(30, 7, number_format($total_with_vat, 2), 1, 1, 'R');
        $this->Ln(5);
    }


    function CustomerAcknowledgementSection()
    {
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 10, "Customer Acknowledgement:\n\nI acknowledge that the items mentioned in this claim have been reviewed and the claim has been processed according to the terms and conditions.");
        $this->Ln(10);
        $this->Cell(95, 10, '______________________', 0, 0, 'C');
        $this->Cell(95, 10, '______________________', 0, 1, 'C');
        $this->Cell(95, 10, 'Authorized by', 0, 0, 'C');
        $this->Cell(95, 10, 'Customer', 0, 1, 'C');
        $this->Ln(10);
        $this->Cell(0, 10, 'Date of Claim: ' . date('Y-m-d'), 0, 1, 'C');
    }
}


// generate-pdf.php

// Generate and return the base64 encoded PDF
function generatePDF($order_id, $order_date, $customer_name, $address, $contact_number, $email, $products, $subtotal, $vat_total, $downpayment, $shipping_cost, $total_with_vat, $balance_due, $vat_percentage, $discount_amount)
{
    $pdf = new CombinedPDF('C-' . $order_id, $order_id, $order_date);

    $pdf->AddPage();
    $pdf->PurchaseOrderHeader();
    $pdf->CustomerSection($customer_name, '', $address, $contact_number, $email);
    $pdf->ShippingSection();

    $actual_subtotal = $pdf->ProductTable($products);
    $pdf->SummarySection($actual_subtotal, $vat_percentage, $shipping_cost, $total_with_vat, $discount_amount, $downpayment, $balance_due);

    $pdf->AddPage();
    $pdf->ClaimSlipHeader();
    $pdf->CustomerSection($customer_name, '', $address, $contact_number, $email);
    $pdf->ClaimItemsTable($products, $actual_subtotal, $vat_total, $total_with_vat, $vat_percentage);
    $pdf->CustomerAcknowledgementSection();

    // Capture PDF output in a buffer and return as base64
    return base64_encode($pdf->Output('S'));
}
