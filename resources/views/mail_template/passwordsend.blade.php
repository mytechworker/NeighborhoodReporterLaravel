<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Document</title>
	</head>
	<body style="padding:0 !important; margin:0 !important; display:block !important; min-width:100% !important; width:100% !important; -webkit-text-size-adjust:none">
		<center style="width: 100%; table-layout: fixed;">
		<div style="margin:10px;padding:10px;max-width:650px; margin:0 auto;" bgcolor="#ffffff" >
			<table style="max-width:320px" width="100%" cellspacing="0" cellpadding="0" bgcolor="#fff">
				
				<tbody><tr>
					<td style="padding:10px 10px">
						
						<table width="100%" cellpadding="0" cellspacing="0">
							<tbody><tr>
								<td bgcolor="#ffffff">
									<table width="600" align="center" style="margin:0 auto" cellpadding="0" cellspacing="0">
										<tbody>
											<tr>
												<td style="padding:40px 10px 0px 0px;background-color:#f9f9f9">
													<table width="100%" cellpadding="0" cellspacing="0" align="center">
														<tbody><tr>
															<th width="113" align="center">
																<table>
																	<tbody><tr>
																		<td style="line-height:0">
																			<a style="text-decoration:none" href="#"><img src="{{ $message->embed('images/logo.png') }}" border="0" style="font:bold 12px/12px Arial,Helvetica,sans-serif;color:#fff" align="center" vspace="0" hspace="0" width="186" height="75" alt="Logo" class="CToWUd"></a>
																		</td>
																	</tr>
																</tbody></table>
															</th>
														</tr>
													</tbody></table>
												</td>
											</tr>
										</tbody></table>
									</td>
								</tr>
							</tbody></table>
							
							<table width="100%" cellpadding="0" cellspacing="0">
								<tbody><tr>
									<td bgcolor="#ffffff">
										<table width="600" align="center" style="margin:0 auto" cellpadding="0" cellspacing="0">
											<tbody>
												<tr>
													<td style="padding:0px 30px 10px" bgcolor="#f9f9f9">
														<table width="100%" cellpadding="0" cellspacing="0">
															<tbody>
																<tr>
																	<td><h4 style="font-size:16px;text-align:left;color:#888">Congratulations! We were able to retrieve your password for Neighbourhood Reporter</h4></td>
																</tr>
																<tr>
																	<td align="left" style="font:14px/16px Arial;color:#888;padding:0 0 23px">
																		Dear {{$data1['user_name']}},<br>
																		<br>
																		You have successfully retrieved password for your Neighbourhood Reporter account.<br><br>
																		<b>Password : {{$data1['user_pwd']}}</b><br>
																		<br>
																		<p style="line-height: 20px">You're receiving this e-mail because you requested a password reset for your Neighbourhood Reporter account.</p>
																		<p>Please tab the button below to choose a new password.</p>
																		<div style="text-align: center; margin-top: 15px">
																			<a href="{{url('update-password')}}" style="height:40px;background-color:#009e13;border:2px solid #009e13;border-radius:50px;color:#ffffff;display:block;font-family:verdana,helvetica,sans-serif;font-size:18px;line-height:40px;text-align:center;text-decoration:none;width:185px;margin: 0 auto" target="_blank">Reset Password</a>
																		</div>
																		
																		<p>Thank You !</p>
																	</td>
																</tr>
															</tbody></table>
														</td>
													</tr>
												</tbody></table>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody></table>
				</div>
			</center>
			</body>
		</html>