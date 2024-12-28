<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contract Agreement</title>
</head>

<body>
    <div class="contract">
        <div class="contract-title">{{ $contract->title }}</div>
        <div class="contract-description">{{ $contract->description }}</div>

        <div class="terms">
            <h3>Terms:</h3>
            <ol>
                @foreach($contract->terms as $term)
                    <div>
                        <p><strong>{{ $loop->iteration }}. {{ $term->title }}</strong></p>
                        <p>{{ $term->description }}</p>
                    </div>
                @endforeach 
            </ol>
        </div>

        <div class="signature-section">
            <div class="signature">
                <p><strong>Customer: {{ $agreement->customer->full_name }}</strong></p>
                <img src="{{ $agreement->customer_signature }}" alt="Customer Signature">
                <p class="signature-name">{{ $agreement->customer->full_name }}</p>
            </div>

            <div class="signature">
                <p><strong>User: {{ $agreement->user->full_name }}</strong></p>
                <img src="{{ $agreement->salesman_signature }}" alt="Salesman Signature">
                <p class="signature-name">{{ $agreement->user->full_name }}</p>
            </div>
        </div>

        <div class="agreement-date">
            <p><strong>Agreement Date:</strong> {{ $agreement->agreement_date->format('F d, Y') }}</p>
        </div>

        <div class="note">
            <p><strong>Note:</strong> {{ $agreement->note }}</p>
        </div>
    </div>
</body>
</html>
