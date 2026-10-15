<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Official MSEUF Digital Event Pass</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f5f7; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #1f2937;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed; background-color: #f4f5f7; padding: 30px 10px;">
        <tr>
            <td align="center">
                <!-- Main Container -->
                <table border="0" cellpadding="0" cellspacing="0" width="600" style="max-width: 600px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 14px rgba(0,0,0,0.06); border: 1px solid #e5e7eb;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #730000; padding: 28px 32px; text-align: left; border-bottom: 3px solid #D4AF37;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td>
                                        <div style="color: #D4AF37; font-size: 11px; font-weight: 800; letter-spacing: 0.12em; text-transform: uppercase; margin-bottom: 4px;">
                                            Manuel S. Enverga University Foundation
                                        </div>
                                        <div style="color: #ffffff; font-size: 20px; font-weight: 800; letter-spacing: -0.01em;">
                                            Official Digital Event Pass Issued
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Verified Status Ribbon -->
                    <tr>
                        <td style="background-color: #fefce8; border-bottom: 1px solid #fef08a; padding: 14px 32px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="color: #854d0e; font-size: 13px; font-weight: 700;">
                                        REGISTRATION APPROVED &bull; PAYMENT CONFIRMED
                                    </td>
                                    <td align="right" style="color: #a16207; font-size: 12px; font-weight: 600;">
                                        Pass # {{ $ticket->ticket_number }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 32px;">
                            <p style="margin: 0 0 16px 0; font-size: 15px; line-height: 1.5; color: #111827;">
                                Dear <strong>{{ $ticket->attendee_name }}</strong>,
                            </p>
                            <p style="margin: 0 0 24px 0; font-size: 14px; line-height: 1.6; color: #4b5563;">
                                Your registration and financial clearance have been verified. Your official electronic event ticket pass is now active and ready for venue entrance.
                            </p>

                            <!-- Event Card Box -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; margin-bottom: 24px;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <div style="font-size: 11px; font-weight: 800; color: #730000; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px;">
                                            {{ $event->category }}
                                        </div>
                                        <div style="font-size: 17px; font-weight: 800; color: #111827; line-height: 1.3; margin-bottom: 10px;">
                                            {{ $event->title }}
                                        </div>
                                        <div style="font-size: 13px; color: #4b5563; line-height: 1.6;">
                                            <strong>Date &amp; Time:</strong> {{ $event->event_date->format('F d, Y • g:i A') }}<br>
                                            <strong>Venue:</strong> {{ $event->location }}<br>
                                            <strong>Organizer:</strong> {{ $event->organizer }}
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <!-- Details Table -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 24px; font-size: 13px;">
                                <tr>
                                    <td style="padding: 8px 0; color: #6b7280; width: 40%; border-bottom: 1px solid #f3f4f6;">Attendee Name:</td>
                                    <td style="padding: 8px 0; color: #111827; font-weight: 700; border-bottom: 1px solid #f3f4f6;">{{ $ticket->attendee_name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; color: #6b7280; border-bottom: 1px solid #f3f4f6;">Student ID:</td>
                                    <td style="padding: 8px 0; color: #111827; font-weight: 700; border-bottom: 1px solid #f3f4f6; font-family: monospace;">{{ $ticket->student_id ?: 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; color: #6b7280; border-bottom: 1px solid #f3f4f6;">Pass Tier:</td>
                                    <td style="padding: 8px 0; color: #111827; font-weight: 600; border-bottom: 1px solid #f3f4f6;">{{ $ticketType->name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; color: #6b7280; border-bottom: 1px solid #f3f4f6;">Total Amount:</td>
                                    <td style="padding: 8px 0; color: #730000; font-weight: 800; border-bottom: 1px solid #f3f4f6;">
                                        {{ $payment && $payment->amount > 0 ? 'PHP ' . number_format($payment->amount, 2) : 'FREE PASS' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; color: #6b7280; border-bottom: 1px solid #f3f4f6;">Payment Reference:</td>
                                    <td style="padding: 8px 0; color: #111827; font-family: monospace; border-bottom: 1px solid #f3f4f6;">{{ $payment ? $payment->reference_number : 'EVG-FREE' }}</td>
                                </tr>
                            </table>

                            <!-- CTA Button -->
                            <div style="text-align: center; margin: 30px 0 20px 0;">
                                <a href="{{ route('tickets.show', $ticket->ticket_number) }}" style="background-color: #D4AF37; color: #1f2937; text-decoration: none; font-size: 13px; font-weight: 800; padding: 13px 28px; border-radius: 6px; display: inline-block; letter-spacing: 0.05em; text-transform: uppercase;">
                                    Open QR Digital Pass
                                </a>
                            </div>

                            <!-- Gate Instruction -->
                            <div style="background-color: #f3f4f6; border-radius: 6px; padding: 14px 16px; font-size: 12px; color: #4b5563; line-height: 1.5;">
                                <strong>Entrance Guideline:</strong> Please present the digital QR code on your mobile phone screen or a printed copy upon arrival. Authorized personnel will scan the code to verify your clearance and grant entry.
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #111827; padding: 24px 32px; text-align: center; color: #9ca3af; font-size: 11px; line-height: 1.6;">
                            <div style="color: #ffffff; font-weight: 700; font-size: 12px; margin-bottom: 4px;">
                                Manuel S. Enverga University Foundation
                            </div>
                            Autonomous Status granted by CHED &bull; ISO 9001:2015 Certified<br>
                            University Site, Brgy. Ibabang Dupay, Lucena City, Quezon 4301, Philippines<br>
                            This is an automated system notification. Replies to this email address are not monitored.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
