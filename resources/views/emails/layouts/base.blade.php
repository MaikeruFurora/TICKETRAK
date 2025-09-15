<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Notification' }}</title>
</head>
<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color:#F2FAFB; color:#073A5E;">

    <!-- Container -->
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center" style="padding: 30px 15px;">

                <!-- Card -->
                <table width="600" cellpadding="0" cellspacing="0" role="presentation" style="background-color:#ffffff; border-radius:12px; overflow:hidden; border:1px solid #e0e0e0;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background-color:#002E5D; padding:20px; text-align:center;">
                            <h1 style="margin:0; font-size:22px; color:#F2FAFB;">{{ config('app.name') }}</h1>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:30px;">
                            @yield('content')
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color:#447795; text-align:center; padding:15px;">
                            <p style="margin:0; font-size:12px; color:#F2FAFB;">
                                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>

</body>
</html>
