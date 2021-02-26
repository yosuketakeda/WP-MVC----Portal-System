<?php
function overdue_email_template($invoice_id, $project, $paid_date, $total, $tax, $rows, $company_name, $billing_address) {

  $html .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html style="width:100%;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0">
   <head>
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta charset="UTF-8">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="telephone=no" name="format-detection">
    <title>Copy of New email template 2020-12-20</title>
    <!--[if (mso 16)]>
      <style type="text/css">
      a {text-decoration: none;}
      </style>
      <![endif]-->
    <!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]-->
    <!--[if gte mso 9]>
  <xml>
      <o:OfficeDocumentSettings>
      <o:AllowPNG></o:AllowPNG>
      <o:PixelsPerInch>96</o:PixelsPerInch>
      </o:OfficeDocumentSettings>
  </xml>
  <![endif]-->
    <!--[if !mso]><!-- -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i" rel="stylesheet">
    <!--<![endif]-->
    <style type="text/css">
  #outlook a {
  	padding:0;
  }
  .ExternalClass {
  	width:100%;
  }
  .ExternalClass,
  .ExternalClass p,
  .ExternalClass span,
  .ExternalClass font,
  .ExternalClass td,
  .ExternalClass div {
  	line-height:100%;
  }
  .es-button {
  	mso-style-priority:100!important;
  	text-decoration:none!important;
  }
  a[x-apple-data-detectors] {
  	color:inherit!important;
  	text-decoration:none!important;
  	font-size:inherit!important;
  	font-family:inherit!important;
  	font-weight:inherit!important;
  	line-height:inherit!important;
  }
  .es-desk-hidden {
  	display:none;
  	float:left;
  	overflow:hidden;
  	width:0;
  	max-height:0;
  	line-height:0;
  	mso-hide:all;
  }
  @media only screen and (max-width:600px) {p, ul li, ol li, a { font-size:16px!important; line-height:150%!important } h1 { font-size:32px!important; text-align:center; line-height:120%!important } h2 { font-size:26px!important; text-align:center; line-height:120%!important } h3 { font-size:20px!important; text-align:center; line-height:120%!important } h1 a { font-size:32px!important } h2 a { font-size:26px!important } h3 a { font-size:20px!important } .es-menu td a { font-size:16px!important } .es-header-body p, .es-header-body ul li, .es-header-body ol li, .es-header-body a { font-size:16px!important } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li, .es-footer-body a { font-size:16px!important } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li, .es-infoblock a { font-size:12px!important } *[class="gmail-fix"] { display:none!important } .es-m-txt-c, .es-m-txt-c h1, .es-m-txt-c h2, .es-m-txt-c h3 { text-align:center!important } .es-m-txt-r, .es-m-txt-r h1, .es-m-txt-r h2, .es-m-txt-r h3 { text-align:right!important } .es-m-txt-l, .es-m-txt-l h1, .es-m-txt-l h2, .es-m-txt-l h3 { text-align:left!important } .es-m-txt-r img, .es-m-txt-c img, .es-m-txt-l img { display:inline!important } .es-button-border { display:inline-block!important } .es-btn-fw { border-width:10px 0px!important; text-align:center!important } .es-adaptive table, .es-btn-fw, .es-btn-fw-brdr, .es-left, .es-right { width:100%!important } .es-content table, .es-header table, .es-footer table, .es-content, .es-footer, .es-header { width:100%!important; max-width:600px!important } .es-adapt-td { display:block!important; width:100%!important } .adapt-img { width:100%!important; height:auto!important } .es-m-p0 { padding:0!important } .es-m-p0r { padding-right:0!important } .es-m-p0l { padding-left:0!important } .es-m-p0t { padding-top:0!important } .es-m-p0b { padding-bottom:0!important } .es-m-p20b { padding-bottom:20px!important } .es-mobile-hidden, .es-hidden { display:none!important } tr.es-desk-hidden, td.es-desk-hidden, table.es-desk-hidden { width:auto!important; overflow:visible!important; float:none!important; max-height:inherit!important; line-height:inherit!important } tr.es-desk-hidden { display:table-row!important } table.es-desk-hidden { display:table!important } td.es-desk-menu-hidden { display:table-cell!important } .es-menu td { width:1%!important } table.es-table-not-adapt, .esd-block-html table { width:auto!important } table.es-social { display:inline-block!important } table.es-social td { display:inline-block!important } a.es-button, button.es-button { font-size:16px!important; display:inline-block!important } .es-m-p5 { padding:5px!important } .es-m-p5t { padding-top:5px!important } .es-m-p5b { padding-bottom:5px!important } .es-m-p5r { padding-right:5px!important } .es-m-p5l { padding-left:5px!important } .es-m-p10 { padding:10px!important } .es-m-p10t { padding-top:10px!important } .es-m-p10b { padding-bottom:10px!important } .es-m-p10r { padding-right:10px!important } .es-m-p10l { padding-left:10px!important } .es-m-p15 { padding:15px!important } .es-m-p15t { padding-top:15px!important } .es-m-p15b { padding-bottom:15px!important } .es-m-p15r { padding-right:15px!important } .es-m-p15l { padding-left:15px!important } .es-m-p20 { padding:20px!important } .es-m-p20t { padding-top:20px!important } .es-m-p20r { padding-right:20px!important } .es-m-p20l { padding-left:20px!important } .es-m-p25 { padding:25px!important } .es-m-p25t { padding-top:25px!important } .es-m-p25b { padding-bottom:25px!important } .es-m-p25r { padding-right:25px!important } .es-m-p25l { padding-left:25px!important } .es-m-p30 { padding:30px!important } .es-m-p30t { padding-top:30px!important } .es-m-p30b { padding-bottom:30px!important } .es-m-p30r { padding-right:30px!important } .es-m-p30l { padding-left:30px!important } .es-m-p35 { padding:35px!important } .es-m-p35t { padding-top:35px!important } .es-m-p35b { padding-bottom:35px!important } .es-m-p35r { padding-right:35px!important } .es-m-p35l { padding-left:35px!important } .es-m-p40 { padding:40px!important } .es-m-p40t { padding-top:40px!important } .es-m-p40b { padding-bottom:40px!important } .es-m-p40r { padding-right:40px!important } .es-m-p40l { padding-left:40px!important } p, ul li, ol li { } .es-header-body p, .es-header-body ul li, .es-header-body ol li { } .es-footer-body p, .es-footer-body ul li, .es-footer-body ol li { } .es-infoblock p, .es-infoblock ul li, .es-infoblock ol li { } }
  </style>
   </head>
   <body data-new-gr-c-s-check-loaded="14.984.0" data-gr-ext-installed sapling-installed="true" style="width:100%;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0">
    <div class="es-wrapper-color" style="background-color:#EEEEEE">
     <!--[if gte mso 9]>
  			<v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
  				<v:fill type="tile" color="#eeeeee"></v:fill>
  			</v:background>
  		<![endif]-->
     <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top">
       <tr style="border-collapse:collapse">
        <td valign="top" style="padding:0;Margin:0">
         <table cellpadding="0" cellspacing="0" class="es-header" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top">
           <tr style="border-collapse:collapse">
            <td align="center" style="padding:0;Margin:0">
             <table bgcolor="#044767" class="es-header-body" align="center" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#044767;border-top:10px solid transparent;border-right:10px solid transparent;border-left:10px solid transparent;width:590px;border-bottom:10px solid transparent">
               <tr style="border-collapse:collapse">
                <td align="left" style="padding:0;Margin:0">
                 <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                   <tr style="border-collapse:collapse">
                    <td align="center" valign="top" style="padding:0;Margin:0;width:570px">
                     <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                       <tr style="border-collapse:collapse">
                        <td align="center" style="padding:0;Margin:0;padding-left:15px;font-size:0px"><a target="_blank" href="https://dronespointofview.com" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;font-size:14px;text-decoration:none;color:#FFFFFF"><img class="adapt-img" src="https://nobtoa.stripocdn.email/content/guids/CABINET_dccef1567f66cd50f0501120b2113035/images/84761606370181292.png" alt style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" width="420"></a></td>
                       </tr>
                     </table></td>
                   </tr>
                 </table></td>
               </tr>
             </table></td>
           </tr>
         </table>
         <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
           <tr style="border-collapse:collapse">
            <td align="center" style="padding:0;Margin:0">
             <table class="es-content-body" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:590px">
               <tr style="border-collapse:collapse">
                <td align="left" style="padding:0;Margin:0">
                 <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                   <tr style="border-collapse:collapse">
                    <td valign="top" align="center" style="padding:0;Margin:0;width:590px">
                     <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                       <tr style="border-collapse:collapse">
                        <td align="center" style="Margin:0;padding-top:25px;padding-bottom:25px;padding-right:30px;padding-left:40px;font-size:0px"><img src="https://nobtoa.stripocdn.email/content/guids/CABINET_dccef1567f66cd50f0501120b2113035/images/80351606372557149.png" alt style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" width="120"></td>
                       </tr>
                       <tr style="border-collapse:collapse">
                        <td align="center" sapling-input-id="cd764282-a075-49e0-8500-726f2526487c" sapling-id="98cdfdaf-4d61-4101-9407-2860000e8653" style="padding:0;Margin:0;padding-bottom:10px"><h2 style="Margin:0;line-height:36px;mso-line-height-rule:exactly;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;font-size:30px;font-style:normal;font-weight:bold;color:#333333">Thank You For Your Payment!</h2>
                         </td>
                       </tr>
                       <tr style="border-collapse:collapse">
                        <td class="es-m-p0" align="center" sapling-id="92ca7e32-b560-4b90-812d-c1a801272cae" sapling-input-id="331916f1-6d95-4bee-90c9-6a4a6f54d6f1" style="padding:0;Margin:0;padding-left:30px;padding-right:35px">
                          <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:17px;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;line-height:26px;color:#777777">Here are the&nbsp;details about your Check&nbsp;payment to Drones Point of View on&nbsp;' . $paid_date . '.</p>
                        </td>
                       </tr>
                       <tr style="border-collapse:collapse">
                        <td class="es-m-p0" align="center" sapling-id="92ca7e32-b560-4b90-812d-c1a801272cae" sapling-input-id="331916f1-6d95-4bee-90c9-6a4a6f54d6f1" style="padding:0;Margin:0;padding-left:30px;padding-right:35px">
                         </td>
                       </tr>
                     </table></td>
                   </tr>
                 </table></td>
               </tr>
             </table></td>
           </tr>
         </table>
         <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
           <tr style="border-collapse:collapse">
            <td align="center" style="padding:0;Margin:0">
             <table class="es-content-body" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:590px" bgcolor="#ffffff">
               <tr style="border-collapse:collapse">
                <td align="left" style="padding:0;Margin:0;padding-top:20px;padding-left:35px;padding-right:35px">
                 <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                   <tr style="border-collapse:collapse">
                    <td valign="top" align="center" style="padding:0;Margin:0;width:520px">
                     <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                       <tr style="border-collapse:collapse">
                        <td class="es-m-txt-l" bgcolor="#eeeeee" align="left" sapling-id="1ed338fc-c13f-42c0-933b-84939100bdf9" sapling-input-id="21ec4816-a07e-4e11-a05e-5abbe83f25aa" style="Margin:0;padding-left:10px;padding-right:10px;padding-top:15px;padding-bottom:15px">
                         <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:500px" class="cke_show_border" cellspacing="1" cellpadding="1" border="0" align="left" role="presentation">
                           <tr style="border-collapse:collapse">
                            <td width="30%" style="padding:0;Margin:0"><h4 style="Margin:0;line-height:150%;mso-line-height-rule:exactly;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif">Invoice #' . $invoice_id . '&nbsp;</h4></td>
                            <td width="40%" align="left" style="padding:0;Margin:0"><td>
                            <td width="30%" style="padding:0;Margin:0"><h4 style="Margin:0;text-align:center;line-height:150%;mso-line-height-rule:exactly;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif">' . $project . '</h4></td>
                           </tr>
                         </table>
                         </td>
                       </tr>
                     </table></td>
                   </tr>
                 </table></td>
               </tr>
               <tr style="border-collapse:collapse">
                <td align="left" style="padding:0;Margin:0;padding-left:35px;padding-right:35px">
                 <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                   <tr style="border-collapse:collapse">
                    <td valign="top" align="center" style="padding:0;Margin:0;width:520px">
                     <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                       <tr style="border-collapse:collapse">
                        <td class="es-m-txt-c" align="left" sapling-input-id="95b36ff0-151a-43cf-9f67-1f67f3241968" sapling-id="ba0e88f3-bb01-413a-b134-4681427a1e65" style="Margin:0;padding-left:10px;padding-right:10px;padding-top:15px;padding-bottom:15px">
                         <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:500px" class="cke_show_border" cellspacing="1" cellpadding="1" border="0" align="left" role="presentation">';

                           foreach ($rows as $row) :

                           $html .= '<tr style="border-collapse:collapse">
                            <td width="30%" align="left" style="padding:0;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;line-height:24px;color:#333333">' . $row[0] . '</p></td>
                            <td width="50%" align="left" style="padding:0;Margin:0"><td>
                            <td width="20%" align="left" style="padding:0;Margin:0"><p style="Margin:0;text-align:left;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;line-height:24px;color:#333333">$' . $row[1] . '</p></td>
                           </tr>';

                            endforeach;

                         $html .= '</table>
                         </td>
                       </tr>
                     </table></td>
                   </tr>
                 </table></td>
               </tr>
               <tr style="border-collapse:collapse">
                <td align="left" style="padding:0;Margin:0;padding-top:10px;padding-left:35px;padding-right:35px">
                 <table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                   <tr style="border-collapse:collapse">
                    <td valign="top" align="center" style="padding:0;Margin:0;width:520px">
                     <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;border-top:3px solid #EEEEEE;border-bottom:3px solid #EEEEEE" width="100%" cellspacing="0" cellpadding="0" role="presentation">
                       <tr style="border-collapse:collapse">
                        <td align="left" sapling-input-id="95b36ff0-151a-43cf-9f67-1f67f3241968" sapling-id="ba0e88f3-bb01-413a-b134-4681427a1e65" style="Margin:0;padding-left:10px;padding-right:10px;padding-top:15px;padding-bottom:15px">
                         <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:500px" class="cke_show_border" cellspacing="1" cellpadding="1" border="0" align="left" role="presentation">
                           <tr style="border-collapse:collapse">
                            <td width="80%" align="left" style="padding:0;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;line-height:24px;color:#333333">Tax (8.25%)</p></td>
                            <td width="20%" align="left" style="padding:0;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;line-height:24px;color:#333333">$0.00</p></td>
                           </tr>
                         </table>
                         </td>
                       </tr>
                       <tr style="border-collapse:collapse">
                        <td align="left" sapling-input-id="95b36ff0-151a-43cf-9f67-1f67f3241968" sapling-id="4da54034-eab7-4c6c-8d52-3bff5d295625" style="Margin:0;padding-left:10px;padding-right:10px;padding-top:15px;padding-bottom:15px">
                         <table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:500px" class="cke_show_border" cellspacing="1" cellpadding="1" border="0" align="left" role="presentation">
                           <tr style="border-collapse:collapse">
                            <td width="80%" style="padding:0;Margin:0"><h4 style="Margin:0;line-height:22px;mso-line-height-rule:exactly;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;font-size:18px">TOTAL</h4></td>
                            <td width="20%" style="padding:0;Margin:0"><h4 style="Margin:0;line-height:24px;mso-line-height-rule:exactly;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;font-size:20px">$' . $total . '</h4></td>
                           </tr>
                         </table>
                         </td>
                       </tr>
                       <tr style="border-collapse:collapse">
                        <td align="center" style="padding:20px;Margin:0;font-size:0px">
                         <table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                           <tr style="border-collapse:collapse">
                            <td style="padding:0;Margin:0;border-bottom:3px solid #EFEFEF;background:none;height:1px;width:100%;margin:0px"></td>
                           </tr>
                         </table></td>
                       </tr>
                       <tr style="border-collapse:collapse">
                        <td align="center" sapling-input-id="8ed78bdf-2fee-42ea-b5b7-31f58f94e6e4" sapling-id="58109bab-fcf5-4d1d-8dd2-f212a9d1c507" style="padding:0;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:18px;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;line-height:27px;color:#333333"><strong>Billing Address</strong></p>
                         </td>
                       </tr>
                       <tr style="border-collapse:collapse">
                        <td align="center" sapling-input-id="fe07262a-8f1a-4c1b-bd01-cf56812d07e4" sapling-id="079dc08c-8229-44dd-8ed9-f5fcbd715bef" style="padding:0;Margin:0;padding-top:15px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;line-height:24px;color:#333333">' . $company_name . '</p></td>
                       </tr>
                       <tr style="border-collapse:collapse">
                        <td align="center" sapling-input-id="fe07262a-8f1a-4c1b-bd01-cf56812d07e4" sapling-id="524fd2a3-6a4e-464e-8845-410719e38775" style="padding:0;Margin:0;padding-top:15px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;line-height:24px;color:#333333">';

                          foreach($billing_address as $addr) :
                            $html .= '<span>' . $addr . '</span><br />';
                          endforeach;

                        $html .= '</p>
                         </td>
                       </tr>
                       <tr style="border-collapse:collapse">
                        <td align="center" height="45" style="padding:0;Margin:0"></td>
                       </tr>
                     </table></td>
                   </tr>
                 </table></td>
               </tr>
             </table></td>
           </tr>
         </table>
         <table cellpadding="0" cellspacing="0" class="es-footer" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top">
           <tr style="border-collapse:collapse">
            <td align="center" style="padding:0;Margin:0">
             <table class="es-footer-body" cellspacing="0" cellpadding="0" align="center" bgcolor="#044767" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#044767;width:590px">
               <tr style="border-collapse:collapse">
                <td class="esdev-adapt-off" style="padding:25px;Margin:0;background-color:#044767" bgcolor="#044767" align="left">
                 <table cellpadding="0" cellspacing="0" class="esdev-mso-table" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;width:540px">
                   <tr style="border-collapse:collapse">
                    <td class="esdev-mso-td" valign="top" style="padding:0;Margin:0">
                     <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
                       <tr style="border-collapse:collapse">
                        <td align="left" style="padding:0;Margin:0;width:154px">
                         <div is-sapling-overlay="true" style="pointer-events:none;box-sizing:content-box;overflow:hidden;padding-bottom:2px;z-index:9999;position:absolute;left:569.5px;top:1065px;height:21px;width:36px;font-style:normal;font-variant:normal;font-weight:400;font-stretch:100%;font-size:16px;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;text-transform:none;letter-spacing:normal;word-spacing:0px;tab-size:8"></div>
                         <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                           <tr style="border-collapse:collapse">
                            <td align="center" class="es-m-txt-c" style="padding:0;Margin:0;font-size:0px"><a target="_blank" href="tel:(310)971-4482" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;font-size:14px;text-decoration:none;color:#333333"><img src="https://nobtoa.stripocdn.email/content/guids/CABINET_dccef1567f66cd50f0501120b2113035/images/14891608517308371.jpg" alt style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" width="32"></a></td>
                           </tr>
                         </table></td>
                        <td style="padding:0;Margin:0;width:40px"></td>
                       </tr>
                     </table></td>
                    <td class="esdev-mso-td" valign="top" style="padding:0;Margin:0">
                     <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
                       <tr style="border-collapse:collapse">
                        <td align="left" style="padding:0;Margin:0;width:153px">
                         <table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                           <tr style="border-collapse:collapse">
                            <td align="center" style="padding:0;Margin:0;font-size:0px"><a target="_blank" href="mailto:info@drones-pov.com" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;font-size:14px;text-decoration:none;color:#333333"><img src="https://nobtoa.stripocdn.email/content/guids/CABINET_dccef1567f66cd50f0501120b2113035/images/52351610416378449.png" alt style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" height="32"></a></td>
                           </tr>
                         </table></td>
                        <td style="padding:0;Margin:0;width:40px"></td>
                       </tr>
                     </table></td>
                    <td class="esdev-mso-td" valign="top" style="padding:0;Margin:0">
                     <table cellpadding="0" cellspacing="0" class="es-right" align="right" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right">
                       <tr style="border-collapse:collapse">
                        <td align="left" style="padding:0;Margin:0;width:153px">
                         <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                           <tr style="border-collapse:collapse">
                            <td align="center" class="es-m-txt-c" style="padding:0;Margin:0;font-size:0px"><a target="_blank" href="https://dronespointofview.com" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:\'open sans\', \'helvetica neue\', helvetica, arial, sans-serif;font-size:14px;text-decoration:none;color:#333333"><img src="https://nobtoa.stripocdn.email/content/guids/CABINET_dccef1567f66cd50f0501120b2113035/images/25191610416041587.png" alt style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" height="37"></a></td>
                           </tr>
                         </table></td>
                       </tr>
                     </table></td>
                   </tr>
                 </table></td>
               </tr>
             </table></td>
           </tr>
         </table></td>
       </tr>
     </table>
    </div>
   </body>
  </html>';


	return $html;
 } ?>
