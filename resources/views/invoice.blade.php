<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #1001</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; color:#333; }
        .container { width: 100%; margin: 0 auto; }
        .header, .meta { width: 100%; }
        .header td { vertical-align: top; }
        .brand { font-size: 20px; font-weight: bold; color: #2a9d8f; }
        .address { font-size: 12px; margin-top: 5px; }
        .meta { text-align: right; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f8f8f8; }
        .text-right { text-align: right; }
        .totals { width: 40%; float: right; margin-top: 15px; }
        .notes { margin-top: 40px; font-size: 12px; }
    </style>
</head>
<body>
<div class="container">

    <!-- Header -->
    <table class="header">
        <tr>
            <td width="60%">
                <div class="brand">Acme Web Studio</div>
                <div class="address">
                    88 Creative Lane, Powai, Mumbai<br>
                    GSTIN: 27ABCDE1234F1Z5<br>
                    Email: billing@acmeweb.in | Phone: +91 98765 43210
                </div>
            </td>
            <td width="40%" class="meta">
                <strong>Invoice #:</strong> 1001 <br>
                <strong>Date:</strong> 07-09-2025 <br><br>
                <strong>Bill To:</strong><br>
                John Doe<br>
                john.doe@example.com<br>
                123 Main Street, Mumbai, India
            </td>
        </tr>
    </table>

    <!-- Items -->
    <table>
        <thead>
            <tr>
                <th width="5%">#</th>
                <th>Description</th>
                <th width="10%">Qty</th>
                <th width="20%">Unit Price (₹)</th>
                <th width="20%">Total (₹)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Website design & development (Single page + CMS)</td>
                <td class="text-right">1</td>
                <td class="text-right">15,000.00</td>
                <td class="text-right">15,000.00</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Domain registration (1 year)</td>
                <td class="text-right">1</td>
                <td class="text-right">800.00</td>
                <td class="text-right">800.00</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Hosting (1 year)</td>
                <td class="text-right">1</td>
                <td class="text-right">2,500.00</td>
                <td class="text-right">2,500.00</td>
            </tr>
        </tbody>
    </table>

    <!-- Totals -->
    <table class="totals">
        <tr>
            <td>Subtotal</td>
            <td class="text-right">₹ 18,300.00</td>
        </tr>
        <tr>
            <td>Tax (18%)</td>
            <td class="text-right">₹ 3,294.00</td>
        </tr>
        <tr>
            <th>Grand Total</th>
            <th class="text-right">₹ 21,594.00</th>
        </tr>
    </table>

    <!-- Notes -->
    <div class="notes">
        <strong>Notes:</strong><br>
        Payment due within 15 days. Please make the payment to:
        ACME WEB STUDIO — A/C: 1234567890 — HDFC Bank — IFSC: HDFC0001234
    </div>

</div>
</body>
</html>
