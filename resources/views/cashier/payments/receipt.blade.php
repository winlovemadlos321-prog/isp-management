<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt #{{ $payment->receipt_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .receipt {
            max-width: 400px;
            margin: 0 auto;
            background: white;
            border: 1px solid #ddd;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #f97316;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        .company-name {
            font-size: 20px;
            font-weight: bold;
            color: #1e3a8a;
        }
        .company-tag {
            font-size: 12px;
            color: #666;
        }
        .receipt-title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin: 15px 0;
        }
        .receipt-number {
            text-align: center;
            font-size: 14px;
            color: #f97316;
            margin-bottom: 15px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 13px;
        }
        .info-label {
            font-weight: bold;
            color: #555;
        }
        .divider {
            border-top: 1px dashed #ddd;
            margin: 15px 0;
        }
        .amount-row {
            display: flex;
            justify-content: space-between;
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            font-size: 11px;
            color: #888;
        }
        .thankyou {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin-top: 15px;
        }
        @media print {
            body {
                padding: 0;
                margin: 0;
            }
            .no-print {
                display: none;
            }
            .receipt {
                border: none;
                padding: 10px;
            }
        }
        .print-btn {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            background: #f97316;
            color: white;
            text-align: center;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
        }
        .print-btn:hover {
            background: #ea580c;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <div class="company-name">GameTech UNLI FIBER</div>
            <div class="company-tag">Internet Service Provider</div>
            <div class="company-tag">24/7 Customer Support: (02) 1234 5678</div>
        </div>
        
        <div class="receipt-title">OFFICIAL RECEIPT</div>
        <div class="receipt-number">Receipt #: {{ $payment->receipt_number }}</div>
        
        <div class="divider"></div>
        
        <div class="info-row">
            <span class="info-label">Date:</span>
            <span>{{ $payment->payment_date->format('F d, Y h:i A') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Customer Name:</span>
            <span>{{ $payment->customer->name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Customer #:</span>
            <span>{{ $payment->customer->customer_number }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Plan:</span>
            <span>{{ $payment->customer->plan_name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Payment Method:</span>
            <span>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</span>
        </div>
        @if($payment->reference_number)
        <div class="info-row">
            <span class="info-label">Reference #:</span>
            <span>{{ $payment->reference_number }}</span>
        </div>
        @endif
        <div class="info-row">
            <span class="info-label">Received By:</span>
            <span>{{ $payment->receivedBy->name ?? 'Cashier' }}</span>
        </div>
        
        <div class="divider"></div>
        
        <div class="amount-row">
            <span>AMOUNT PAID:</span>
            <span style="color: #f97316;">₱{{ number_format($payment->amount, 2) }}</span>
        </div>
        
        <div class="divider"></div>
        
        <div class="info-row">
            <span class="info-label">New Expiry Date:</span>
            <span>{{ \Carbon\Carbon::parse($payment->customer->expiry_date)->format('F d, Y') }}</span>
        </div>
        
        <div class="thankyou">
            Thank you for your payment!
        </div>
        
        <div class="footer">
            This is a system-generated receipt.<br>
            For inquiries, please contact our support team.
        </div>
    </div>
    
    <button onclick="window.print();" class="print-btn no-print">
        <i class="fas fa-print"></i> Print / Save as PDF
    </button>
    
    <div style="text-align: center; margin-top: 10px;" class="no-print">
        <a href="{{ route('cashier.dashboard') }}" style="color: #f97316;">Back to Dashboard</a>
    </div>
</body>
</html>