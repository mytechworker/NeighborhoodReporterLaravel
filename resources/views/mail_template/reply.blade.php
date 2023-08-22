
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
    <head>
        <!--[if gte mso 9]>
        <xml>
        <o:OfficeDocumentSettings>
        <o:AllowPNG/>
        <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
        </xml>
        <style type="text/css"> .preheader
        {display: none}</style>
        <![endif]-->
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="format-detection" content="date=no" />
        <meta name="format-detection" content="address=no" />
        <meta name="format-detection" content="telephone=no" />
        <meta name="x-apple-disable-message-reformatting" />
        <title>Email Template</title>
        <!--[if gte mso 9]>
        <style type="text/css" media="all">
        sup { font-size: 100% !important; }
        </style>
        <![endif]-->
        <style type="text/css">
            * {margin-top:0px;margin-bottom:0px;padding:0px 10px 0px 10px;border:none;outline:none;list-style:none;-webkit-text-size-adjust: none;}
            body {margin:0 !important;padding:0 !important;width: 100% !important;-webkit-text-size-adjust: 100% !important;-ms-text-size-adjust: 100% !important;-webkit-font-smoothing: antialiased !important;}
            img {border:0 !important;display: block !important;outline: none !important;}
            table {border-collapse: collapse;mso-table-lspace:0px;mso-table-rspace: 0px;}
            td {border-collapse:collapse;mso-line-height-rule:exactly;}
            .ExternalClass {width: 100%;line-height: 100%;}
            a[x-apple-data-detectors] {color: inherit !important;text-decoration: none !important;font-size: inherit !important;font-family: inherit !important;font-weight: inherit !important;line-height: inherit !important;}
            @media only screen and (max-width:480px){
                .width_100percent {width: 100% !important;}
                .min_width {min-width: 320px !important;}
                .mobile_img {width: 100% !important; height: auto !important;}
                .hide {display: none !important;}
                .show {display: block !important; width: auto !important; overflow: visible !important; float: none !important; max-height: inherit !important; line-height: inherit !important;}
                .width_10 {width: 10px !important;}
                .width_20 {width: 20px !important;}
                .width_30 {width: 30px !important;}
                .height_10 {height: 10px !important;}
                .height_20 {height: 20px !important;}
                .height_30 {height: 30px !important;}
                .height_40 {height: 40px !important;}
                .font_24 {font-size: 24px !important;line-height:27px !important;}
            }
        </style>
    </head>
    <body class="body" style="padding:0 !important; margin:0 !important; display:block !important; min-width:100% !important; width:100% !important; background:#ffffff; -webkit-text-size-adjust:none">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
            <tr>
                <td align="center" valign="top" style="border-bottom: 4px solid #06bf29; padding: 16px 0;">
                    <table width="500" border="0" cellspacing="0" cellpadding="0" class="mobile-shell">
                        <tr>
                            <td align="center" class="td" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; Margin:0;">
                                <!-- Header -->
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td align="center" width="50%" style="padding: 10px; font-size: 0pt; line-height: 0pt; text-align: center;">
                                            <a href="{{route('home')}}" target="_blank">
                                                <img src="{{ $message->embed('images/logo.png') }}" style="margin-right: 10px;" border="0" alt="" class="head-logo"/>
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                                <!-- END Header -->
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <!-- END Header -->
            <!-- Content -->
            <tr>
                <td align="center" valign="top">
                    <table width="500" border="0" cellspacing="0" cellpadding="0" class="mobile-shell">
                        <tr>
                            <td class="td" style="width:600px; min-width:600px; font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; Margin:0">
                                <!-- Intro -->
                                <!-- =======  Message  ======= -->
                                <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#fffffe">
                                    <td align="left" valign="top" style="padding:20px 20px;">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <!-- header -->
                                            <tr><td align="center" valign="top" style="font-family:Verdana,sans-serif;color:#000000;font-size:24px;line-height:120%;font-weight:bold; padding-bottom: 20px;">You have a new reply</td></tr>
                                            <tr><td align="center" valign="top" style="font-family:Arial,sans-serif;color:#111111;font-size:20px;line-height:120%;">{{$data['name']}} just replied to you on Neighborhood Reporter.</span></td></tr>
                                            <tr><td height="20" style="line-height:1px;font-size:1px;">&nbsp;</td></tr>
                                            <tr><td align="center"><a href="{{$data['link']}}" target="_blank" name="See reply" title="" style="width:274px;font-size:18px;line-height:22px;font-family:Arial,sans-serif;color:#fffffe;text-align:center; font-weight: bold; display:block;padding:12px 0;text-decoration:none;background-color:#009E13;border-radius:32px;border:2px solid #06bd2a;font-weight:bold;mso-border-alt:none;">See reply</a></td></tr>
                                            <tr><td height="30" style="line-height:1px;font-size:1px;">&nbsp;</td></tr>
                                        </table>
                                    </td>
                                </table>
                                <!-- 3 Rows of Title / Text / Button / Socials -->
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>

                                        <td style="padding:25px 0">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="padding-bottom:9px">
                                                            <div style="color:#808080;font-family:Helvetica,Arial,sans-serif;font-size:11px;line-height:15px;text-align:center">
                                                                Don't want to receive notification emails like this one? You can always opt out on <br/>
                                                                <a href="{{route('settings-email')}}?sid={{$data['user_id']}}&utm_source=newsletter-daily&utm_medium=email&utm_campaign=24939442&utm_content=DNL-2021-08-18&unsubscribe" style="color:#666666;text-decoration:none" target="_blank">your email settings page.</a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div style="color:#b0b0b0;font-family:Helvetica,Arial,sans-serif;font-size:9px;line-height:13px;text-align:center">Neighborhood Reporter Media | 134 W 29th Street, New York, NY 10001
                                                                <br>Copyright &copy; 2021 Neighborhood Reporter Media. All rights reserved.
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>