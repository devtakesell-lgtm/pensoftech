<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Status Update</title>
    <style>
        /* CSS reset and general styles for email clients */
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; }
        img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        table { border-collapse: collapse !important; }
        body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f6f9; color: #333333; }
        a[x-apple-data-detectors] { color: inherit !important; text-decoration: none !important; font-size: inherit !important; font-family: inherit !important; font-weight: inherit !important; line-height: inherit !important; }
        
        /* Layout styles */
        .wrapper { width: 100%; table-layout: fixed; background-color: #f4f6f9; padding-bottom: 60px; }
        .main-container { max-width: 600px; margin: 0 auto; width: 100%; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05); margin-top: 40px; }
        
        /* Header */
        .header { background-color: #ffffff; padding: 30px 40px; border-bottom: 2px solid #f0f0f0; text-align: center; }
        .header h1 { margin: 0; color: #1a1a1a; font-size: 24px; font-weight: 700; letter-spacing: -0.5px; }
        
        /* Body Content */
        .content { padding: 40px; }
        .content h2 { margin-top: 0; font-size: 22px; color: #1a1a1a; font-weight: 600; margin-bottom: 20px; }
        .content p { margin-top: 0; margin-bottom: 20px; font-size: 16px; line-height: 1.6; color: #4a4a4a; }
        
        /* Status Badge */
        .status-box { background-color: #f8f9fa; border-left: 4px solid #0052cc; padding: 15px 20px; margin-bottom: 25px; border-radius: 0 4px 4px 0; }
        .status-box p { margin: 0; font-weight: 600; color: #1a1a1a; }
        
        /* Button */
        .btn-container { text-align: center; margin: 35px 0; }
        .btn { display: inline-block; background-color: #0052cc; color: #ffffff !important; text-decoration: none; padding: 14px 28px; border-radius: 6px; font-weight: 600; font-size: 16px; letter-spacing: 0.3px; }
        
        /* Footer */
        .footer { padding: 30px 40px; background-color: #f8f9fa; border-top: 1px solid #eeeeee; text-align: center; }
        .footer p { margin: 0; font-size: 13px; color: #888888; line-height: 1.5; }
        
        @media screen and (max-width: 600px) {
            .content { padding: 30px 20px; }
            .header { padding: 25px 20px; }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6f9;">

<center class="wrapper">
    <table class="main-container" border="0" cellpadding="0" cellspacing="0" width="100%">
        <!-- Header -->
        <tr>
            <td class="header">
                <!-- If you have a logo, uncomment and place URL here -->
                <!-- <img src="https://yourdomain.com/logo.png" alt="Logo" width="150" style="margin-bottom: 15px;"> -->
                <h1 style="color: #1a1a1a; margin: 0;">{{ config('app.name') }}</h1>
            </td>
        </tr>
        
        <!-- Main Content -->
        <tr>
            <td class="content">
                <h2>Application Status Update</h2>
                
                <p>Dear {{ $jobApplication->name }},</p>
                
                <p>Thank you for applying for the <strong>{{ $jobApplication->job->title ?? 'open position' }}</strong> role at {{ config('app.name') }}. We have carefully reviewed your application, and we are writing to share an update.</p>
                
                <div class="status-box">
                    <p>Current Status: 
                        <span style="color: #0052cc;">
                            {{ \App\Enums\JobApplicationStatus::tryFrom($jobApplication->status->value)?->label() ?? ucfirst($jobApplication->status->value) }}
                        </span>
                    </p>
                </div>
                
                @if($jobApplication->status->value === 'shortlisted')
                    <p>We are pleased to inform you that you have been selected to move forward to the next stage! We were very impressed by your background and experience.</p>
                    
                    <div class="btn-container">
                        <a href="{{ config('app.url') }}" class="btn">View Next Steps</a>
                    </div>
                @elseif($jobApplication->status->value === 'interviewed')
                    <p>Thank you so much for taking the time to meet with us. Our team truly enjoyed getting to know you. We are currently finalizing our feedback and will be in touch shortly.</p>
                @elseif($jobApplication->status->value === 'offered')
                    <p>Congratulations! We are thrilled to offer you the position. Please check your inbox for a separate email containing your official offer letter and details.</p>
                @elseif($jobApplication->status->value === 'hired')
                    <p>Welcome to the team! We are so excited to have you onboard.</p>
                @elseif($jobApplication->status->value === 'rejected')
                    <p>While your background is impressive, we have decided to move forward with other candidates whose experience more closely matches our current needs for this role. We will keep your resume on file for future openings.</p>
                    <p>We wish you the best of luck in your job search!</p>
                @else
                    <p>We will keep you informed of any further updates regarding your application.</p>
                @endif
                
                <p style="margin-top: 30px; margin-bottom: 0;">Best regards,<br>
                <strong>The {{ config('app.name') }} Hiring Team</strong></p>
            </td>
        </tr>
        
        <!-- Footer -->
        <tr>
            <td class="footer">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                <p style="margin-top: 5px;">This is an automated message, please do not reply directly to this email.</p>
            </td>
        </tr>
    </table>
</center>

</body>
</html>
