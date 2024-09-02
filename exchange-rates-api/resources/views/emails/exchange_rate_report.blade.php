<!DOCTYPE html>
<html>
<head>
    <title>Daily Exchange Rate Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            margin: 0 auto;
            padding: 20px;
            max-width: 600px;
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
        }
        .content {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .footer {
            text-align: center;
            font-size: 0.9em;
            color: #777;
        }
        .footer p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Daily Exchange Rate Report</h1>
        </div>

        <div class="content">
            <p>Hello,</p>

            <p>Please find attached the exchange rate report for <strong>{{ $date }}</strong>.</p>

            <p>This report includes the latest exchange rates for various currencies against USD. You can use this data to track currency trends, make financial decisions, or for any other purpose requiring up-to-date exchange rate information.</p>

            <h3>Summary</h3>
            <ul>
                <li>Total currencies included: {{ $totalCurrencies }}</li>
                <li>Base currency: USD</li>
                <li>Date of report: {{ $date }}</li>
            </ul>

            <p>The full data is available in the attached CSV file, which can be opened in any spreadsheet application (e.g., Microsoft Excel, Google Sheets) or text editor.</p>

            <p>If you have any questions or need further assistance, please feel free to reply to this email.</p>
        </div>

        <div class="footer">
            <p>Thank you for using our service!</p>
            <p>&copy; {{ date('Y') }} Your Company Name. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
