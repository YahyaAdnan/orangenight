<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contract Agreement</title>
    <style>
        /* Ensure the page behaves like an A4 size page */
        @page {
            size: A4;
            margin: 20mm; /* Adjust margins to suit your needs */
        }

        body {
            font-family: 'NotoSansArabic', sans-serif;
            direction: rtl;
            margin: 0;
            padding: 0;
            background-color: #fdfdfd;
        }

        /* Background image settings */
        .background-image {
            width: 100%; /* Ensures image width matches A4 size */
            height: auto; /* Keeps aspect ratio intact */
            position: relative;
            top: 0;
            left: 0;
            z-index: -1; /* Places the background behind other content */
        }

        .contract {
            position: relative; /* Allow content to sit on top of the background */
            z-index: 1;
            padding: 20px;
            border-radius: 10px;
            width: 100%;
            box-sizing: border-box;
        }

        /* Title styling */
        h1.contract-title {
            text-align: center; /* Centers the title */
            font-size: 2em; /* Make the title bigger */
            margin-bottom: 20px; /* Add space below the title */
        }

        /* Signature section settings */
        .signature-section {
            display: flex; /* Use flexbox to align signatures side by side */
            justify-content: space-evenly; /* Distribute space evenly between signatures */
            align-items: center; /* Vertically center the signature containers */
            margin-top: 30px; /* Optional: Add space between the section and the signatures */
            height: 33%; /* Signature section takes 1/3 of the page height */
        }

        .signature {
            text-align: center; /* Align text and images within each signature box */
            width: 40%; /* Adjust width to fit both signatures side by side */
            display: flex;
            flex-direction: column;
            justify-content: center; /* Center the content vertically */
        }

        .signature img {
            max-width: 150px; /* Set a larger size for the signature images */
            height: auto;
            margin-bottom: 10px;
        }

        .signature-name {
            margin-top: 5px; /* Optional: Add some space between the signature and the name */
        }

        .contract-description {
            margin-bottom: 20px; /* Optional: Add spacing between contract title and description */
        }

        .agreement-date, .note {
            margin-top: 20px; /* Optional: Add space before agreement date and note */
        }
    </style>
</head>

<body>
    @php
        App::setLocale(request()->cookies->all()['filament_language_switch_locale']);   
    @endphp
    <!-- Background image placed at the top with full width -->
    <img src="{{ asset('assets/background.png') }}" class="background-image" alt="Contract Background">

    <!-- Main contract content -->
    <div class="contract">
        <!-- Contract title changed to h1 and centered -->
        <h1 class="contract-title">{{ $contract->title }}</h1>
        <div class="contract-description">{{ $contract->description }}</div>

        <div class="terms">
            <h3>{{__('terms')}}:</h3>
            <ol>
                @foreach($contract->terms as $term)
                    <div>
                        <p><strong>{{ $loop->iteration }}. {{ $term->title }}</strong></p>
                        <p>{{ $term->description }}</p>
                    </div>
                @endforeach 
            </ol>
        </div>
        <hr>
        <div class="signature-section">
            <div class="signature">
                <p><strong>{{__('customer')}}: {{ $agreement->customer->full_name }}</strong></p>
                <img src="{{ $agreement->customer_signature }}" alt="Customer Signature">
                <p class="signature-name">{{ $agreement->customer->full_name }}</p>
            </div>

            <div class="signature">
                <p><strong>{{__('sales_man')}}: {{ $agreement->user->full_name }}</strong></p>
                <img src="{{ $agreement->salesman_signature }}" alt="Salesman Signature">
                <p class="signature-name">{{ $agreement->user->full_name }}</p>
            </div>
        </div>

        <div class="agreement-date">
            <p><strong>{{__('agreement_date')}}:</strong> {{ $agreement->agreement_date->format('d/m/Y') }}</p>
        </div>

        @if( $agreement->note )
        <div class="note">
            <p><strong>{{__('note')}}:</strong> {{ $agreement->note }}</p>
        </div>
        @endif
    </div>

</body>
</html>
