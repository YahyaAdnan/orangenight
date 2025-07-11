<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Receipt</title>
    <style>
        /* General Styles */
        body {
            font-family: 'NotoSansArabic', sans-serif;
            direction: rtl;
            margin: 0;
            padding: 0;
            background-color: #fdfdfd;
        }

        .receipt {
            margin: auto;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        h1.receipt-title {
            text-align: center;
            font-size: 2em;
            margin-bottom: 20px;
        }

        .receipt-details {
            margin: 20px 0;
            line-height: 1.6;
        }

        .receipt-details p {
            margin: 5px 0;
        }

        .receipt-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .receipt-table th, .receipt-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        .receipt-table th {
            background-color: #f8f8f8;
        }

        .status {
            font-weight: bold;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .status.pending {
            background-color: orange;
        }

        .status.delivered {
            background-color: green;
        }

        .status.cancel {
            background-color: red;
        }

        .signature-section {
            margin-top: 30px;
            text-align: center;
        }

        .signature-section img {
            max-width: 200px;
            height: auto;
        }

        .signature-section p {
            margin: 10px 0 0;
        }

        /* Print Button Styles */
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            z-index: 1000;
        }

        .print-button:hover {
            background-color: #0056b3;
        }

        /* Printable styles */
        @media print {
            .print-button {
                display: none;
            }

            body {
                background-color: #fff;
                margin: 0;
                padding: 0;
            }

            body > *:not(.receipt) {
                display: none;
            }

            .receipt {
                margin: 0;
                padding: 0;
                box-shadow: none;
                width: 100%;
                background-color: #fff;
            }

            .receipt img {
                display: block;
                width: 100%;
                height: auto;
            }

            .signature-section {
                text-align: right;
                margin: 0 auto;
            }

            .signature-section img {
                display: block;
                margin: 0 auto; /* Center the image */
                max-width: 200px; /* Ensure the size doesn't exceed limits */
                height: auto;
            }

            .signature-section p {
                text-align: center;
                margin: 0;
            }
        }
    </style>
</head>

<body>
    @php
        App::setLocale(request()->cookies->all()['filament_language_switch_locale']);   
    @endphp

    <!-- Print Button -->
    <button class="print-button" onclick="window.print()">{{ __('Print') }}</button>

    <!-- Main receipt content -->
    <div class="receipt">
        <img src="{{ asset('assets/background.png') }}" style="width: 100%; height: auto;" alt="Contract Background">

        <!-- Receipt title -->
        <h1 class="receipt-title">{{ __('delivery') }}</h1>

        <!-- Receipt details -->
        <div class="receipt-details">
            <p><strong>{{ __('customer') }}:</strong> {{ $delivery->customer->full_name }}</p>
            <p><strong>{{ __('status') }}:</strong> 
                <span class="status delivered">{{ __($delivery->status) }}</span>
            </p>
        </div>

        <!-- Table of items -->
        <table class="receipt-table">
            <thead>
                <tr>
                    <th>{{ __('item') }}</th>
                    <th>{{ __('quantity') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $delivery->item->title }}</td>
                    <td>{{ $delivery->quantity }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Signature section -->
        <div class="signature-section">
            <p><strong>{{ __('customer_signature') }}</strong></p>
            <img src="{{ $delivery->signature }}" alt="{{ __('Customer Signature') }}">
            <p>{{ $delivery->customer->full_name }} | {{ $delivery->signature_date }}</p>
        </div>        
    </div>
</body>
</html>
