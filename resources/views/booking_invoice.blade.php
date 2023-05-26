	<html>

	<body style="font-family: Open Sans, sans-serif; font-size: 100%; font-weight: 400; line-height: 1.4; color:#000; margin: 0; padding: 0;">
		<table style="width: 100%; max-width: 700px; margin:40px auto; background-color: #fff; border:1px solid #FF8F00; border-top: solid 10px #FF8F00; padding-bottom: 250px; padding: 30px; padding-top: 0;">
			<tbody>
				<tr>
					<td style="width: 100%;">
						<table style="width: 100%;padding: 15px 0; border-bottom: 1px solid #ccc; margin-bottom: 20px;">
							<tr>
								<td style="text-align: left; width: 20%;">
									<img src="https://homi.ezxdemo.com/storage/uploads/sitelogo/Logo.png">
								</td>
							</tr>
							<tr>
								<td style="padding: 5px 0px; font-size: 14px; color: #000; font-weight: 400; width: 50%;text-align: left;">{{$contact_address}}</td>

								<td style="padding: 5px 0px; font-size: 18px; color: #000; font-weight: 700;text-align: right;">Invoice No:</td>
							</tr>

							<tr>
								<td style="padding: 5px 0px; font-size: 14px; color: #000; font-weight: 400; width: 50%;text-align: left;">{{$contact_email}}</td>

								<td style="padding: 5px 0px; font-size: 14px; color: #000; font-weight: 400; width: 50%;text-align: right;">#{{$invoice_id}}</td>
							</tr>

							<tr>
								<td style="padding: 5px 0px; font-size: 14px; color: #000; font-weight: 400; width: 50%;text-align: left;">{{$contact_number}}</td>

								<td style="padding: 5px 0px; font-size: 18px; color: #000; font-weight: 700; width: 50%;text-align: right;">Invoice Date:</td>
							</tr>

							<tr>
								<td style="padding: 5px 0px; font-size: 14px; color: #000; font-weight: 400; width: 50%;text-align: left;"></td>

								<td style="padding: 5px 0px; font-size: 14px; color: #000; font-weight: 400;text-align: right;">{{$booking_date}}</td>
							</tr>

							<tr>
								<td style="padding: 5px 0px; font-size: 14px; color: #000; font-weight: 400; width: 50%;text-align: left;"></td>

								<td style="padding: 5px 0px; font-size: 18px; color: #000; font-weight: 700;text-align: right;">Order No:</td>
							</tr>

							<tr>
								<td style="padding: 5px 0px; font-size: 14px; color: #000; font-weight: 400; width: 50%;text-align: left;"></td>

								<td style="padding: 5px 0px; font-size: 14px; color: #000; font-weight: 400;text-align: right;">#{{$booking_id}}</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td style="width: 100%;">
						<table style="width: 100%; margin:0 auto 15px;">
							<tr>
								<td style="padding: 5px 0px; font-size: 20px; color: #000; font-weight: 700;text-align: left;">Billed To</td>

								<td style="padding: 5px 0px; font-size: 20px; color: #000; font-weight: 700; text-align: right;">Billed From</td>
							</tr>
							<tr>
								<td style="padding: 5px 0px; font-size: 14px; color: #000; font-weight: 400; width: 50%;text-align: left;">{{$user_name}}</td>

								<td style="padding: 5px 0px; font-size: 14px; color: #000; font-weight: 400; width: 50%;text-align: right;">{{$owner_name}}</td>

							</tr>

							<tr>
								<td style="padding: 5px 0px; font-size: 14px; color: #000; font-weight: 400; width: 50%;text-align: left;">{{$user_address}}</td>

								<td style="padding: 5px 0px; font-size: 14px; color: #000; font-weight: 400; width: 50%;text-align: right;">{{$owner_address}}</td>
							</tr>

							<tr>
								<td style="padding: 5px 0px; font-size: 14px; color: #000; font-weight: 400; width: 50%;text-align: left;">{{$user_email}}</td>

								<td style="padding: 5px 0px; font-size: 14px; color: #000; font-weight: 400; width: 50%;text-align: right;">{{$owner_email}}</td>
							</tr>

							<tr>
								<td style="padding: 5px 0px; font-size: 14px; color: #000; font-weight: 400; width: 50%;text-align: left;">{{$user_number}}</td>

								<td style="padding: 5px 0px; font-size: 14px; color: #000; font-weight: 400; width: 50%;text-align: right;">{{$owner_number}}</td>
							</tr>
							
						</table>
					</td>
				</tr>
				<tr>
					<td style="width: 100%; padding-bottom: 20px;">
						<table style="border-collapse: collapse; margin: 0 auto; width: 100%; border: 1px solid #ddd;">
							<tr>
								<td style="font-size: 14px; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; padding: 10px;"><b>Property Title</b></td>

								<td style="font-size: 14px; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; padding: 10px;"><b>Check In-Out Date</b></td>

								<td colspan="2" style="font-size: 14px; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; padding: 10px 0 0 0; text-align: center;"><b>Guest Count</b>
									<table style="width: 100%;border-top: 1px solid #ddd;margin-top: 10px;">
										<tbody><tr>
											<td style=" border-right: 1px solid #ddd; padding: 10px;" colspan="2">Adults</td>
											<td style=" padding: 10px;" colspan="2">Children</td>
										</tr>
									</tbody></table>
								</td>


							</tr>
							<tr>
								<td style="font-size: 14px; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; padding: 5px 10px;">{{$property_title}}</td>
								<td style="font-size: 14px; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; padding: 5px 10px;">{{$check_in_date}} - {{$check_out_date}}</td>
								<td style="font-size: 14px; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; padding: 5px 10px;">{{$adults_count}}</td>

								<td style="font-size: 14px; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; padding: 5px 10px;">{{$children_count}}</td>

							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td width="100%">
						<table width="100%">
							<tr>
								<td width="60%"></td>
								<td width="40%" style="padding-bottom: 20px;">
									<table style="border-collapse: collapse; margin: 0 auto; width: 100%; border: 1px solid #ddd;">
										<tr>
											<th style="font-size: 14px; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; padding: 10px;">Sub Total</th>
											<td style="font-size: 14px; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; padding: 5px 10px;"> {{$subtotal_price}}</td>
										</tr>
										<tr>
											<th style="font-size: 14px; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; padding: 10px;">Tax
											</th>
											<td style="font-size: 14px; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; padding: 5px 10px;">{{$tax_price}}</td>
										</tr>
										<tr>
											<th style="font-size: 16px; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; padding: 10px;"><b>Total</b></th>
											<td style="font-size: 16px; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; padding: 5px 10px;">{{$total_price}}</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				
				
			</tbody>
		</table>
	</body>

	</html>