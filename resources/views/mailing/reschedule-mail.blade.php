<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f8f9fa;
            color: #343a40;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
        }

        .header,
        .footer {
            text-align: center;
            padding: 10px;
        }

        .content {
            margin: 20px 0;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Reschedule Reservation</h1>
        </div>

        <div class="content">
            <p>Dear {{ $reservation->guest->name }},</p>

            <p>We wanted to inform you that your reservation has been successfully rescheduled. Please find the updated
                details of your reservation below:</p>

            <table style="width:100%; border-collapse: collapse;">
                <tr>
                    <th style="text-align:left; padding: 8px; border: 1px solid #ddd;">Reservation Code</th>
                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $reservation->reservation_code }}</td>
                </tr>
                <tr>
                    <th style="text-align:left; padding: 8px; border: 1px solid #ddd;">Original Date</th>
                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $reservation->original_date }}</td>
                </tr>
                <tr>
                    <th style="text-align:left; padding: 8px; border: 1px solid #ddd;">New Date</th>
                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $reservation->reservation_date }}</td>
                </tr>
                {{-- <tr>
                    <th style="text-align:left; padding: 8px; border: 1px solid #ddd;">Time:</th>
                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $reservation->time }}</td>
                </tr> --}}
                <tr>
                    <th style="text-align:left; padding: 8px; border: 1px solid #ddd;">Guest Count</th>
                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $reservation->detail->sum('qty') }} pax</td>
                </tr>
            </table>

            <p>If you have any questions or need further assistance, please don't hesitate to contact us.</p>

            <p>Thank you for your understanding.</p>

            <p>Best regards,<br>Bali Tubing Rafting</p>
        </div>

        <div class="footer">
            <p>Powered by R-Bot</p>
            <p>&copy; {{ date('Y') }} Bali Tubing Rafting. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
