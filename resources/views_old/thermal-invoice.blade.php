<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Thermal Invoice</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Courier New', monospace;
        }

        body {
            width: 58mm;
            /* For thermal printers */
            margin: 0 auto;
            padding: 5px;
            text-align: center;
            font-size: 12px;
            color: #000;
        }

        .invoice-container {
            border-bottom: 1px dashed #000;
            padding-bottom: 5px;
            margin-bottom: 5px;
        }

        .store-name {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .store-details {
            font-size: 10px;
            margin-top: 2px;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .items-table th,
        .items-table td {
            font-size: 11px;
            padding: 2px 0;
        }

        .items-table th {
            border-bottom: 1px dashed #000;
        }

        .items-table td:first-child {
            text-align: left;
        }

        .items-table td:nth-child(2),
        .items-table td:nth-child(3) {
            text-align: right;
        }

        .totals {
            width: 100%;
            margin-top: 5px;
            font-size: 12px;
        }

        .totals td {
            padding: 2px 0;
        }

        .totals td:first-child {
            text-align: left;
        }

        .totals td:last-child {
            text-align: right;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: 8px;
            border-top: 1px dashed #000;
            padding-top: 5px;
        }

        body {
            width: 70mm;
            margin: 0 auto;
            padding: 5px;
            font-size: 12px;
            color: #000;
            height: 150px !important;
        }

        .invoice-container {
            display: inline-block;
            width: 100%;
            border-bottom: 1px dashed #000;
            padding-bottom: 5px;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <div class="store-name">My Shop</div>
        <div class="store-details">
            123 Market Street, City<br>
            Phone: +91 98765 43210
        </div>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Product 1</td>
                <td>2</td>
                <td>₹200</td>
            </tr>
            <tr>
                <td>Product 2</td>
                <td>1</td>
                <td>₹150</td>
            </tr>
            <tr>
                <td>Product 3</td>
                <td>3</td>
                <td>₹300</td>
            </tr>
        </tbody>
    </table>

    <div class="divider"></div>

    <table class="totals">
        <tr>
            <td>Subtotal:</td>
            <td>₹650</td>
        </tr>
        <tr>
            <td>Tax (5%):</td>
            <td>₹32.50</td>
        </tr>
        <tr>
            <td><strong>Total:</strong></td>
            <td><strong>₹682.50</strong></td>
        </tr>
    </table>

    <div class="footer">
        Thank you for shopping!<br>
        Visit us again.
    </div>
</body>

</html>