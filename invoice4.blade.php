<!DOCTYPE html>
<html>

<head>
    <title>Rechnung</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <style type="text/css">
        /* -- Base -- */
        body {
            font-family: "Arial", sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 11px;
            line-height: 1.3;
        }

        html {
            margin: 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
        }

        /* -- Header Section -- */
        .header-container {
            width: 100%;
            margin-bottom: 30px;
            position: relative;
        }

        .logo-container {
            position: absolute;
            top: 0;
            right: 0;
            width: 80px;
            height: 80px;
        }

        .logo {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .company-info {
            margin-top: 60px;
            font-size: 10px;
            color: #666;
        }

        /* -- Address Section -- */
        .address-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }

        .customer-address {
            width: 45%;
        }

        .customer-address .name {
            margin-bottom: 0px;
        }

        .invoice-details {
            width: 45%;
            text-align: right;
        }

        .invoice-details table {
            width: 100%;
            margin-left: auto;
        }

        .invoice-details td {
            padding: 2px 0;
            font-size: 11px;
        }

        .invoice-details .label {
            text-align: left;
            padding-right: 20px;
        }

        .invoice-details .value {
            text-align: right;
            font-weight: bold;
        }

        /* -- Invoice Title -- */
        .invoice-title {
            font-size: 18px;
            font-weight: bold;
            margin: 30px 0 10px 0;
        }

        .invoice-subtitle {
            margin-bottom: 20px;
            font-size: 11px;
        }

        /* -- Items Table -- */
        .items-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .items-table th {
            background-color: #f5f5f5;
            padding: 8px 5px;
            text-align: left;
            font-size: 10px;
            font-weight: bold;
            border-bottom: 1px solid #ddd;
        }

        .items-table th.center {
            text-align: center;
        }

        .items-table th.right {
            text-align: right;
        }

        .items-table td {
            padding: 8px 5px;
            font-size: 10px;
            vertical-align: top;
            border-bottom: 1px solid #eee;
        }

        .items-table td.center {
            text-align: center;
        }

        .items-table td.right {
            text-align: right;
        }

        .item-description {
            font-size: 9px;
            color: #666;
            margin-top: 2px;
        }

        .item-details {
            font-size: 9px;
            color: #666;
            margin-top: 3px;
            line-height: 1.2;
        }

        /* -- Totals Section -- */
        .totals-section {
            margin-top: 20px;
        }

        .totals-table {
            width: 100%;
            margin-bottom: 10px;
        }

        .totals-table td {
            padding: 3px 0;
            font-size: 11px;
        }

        .totals-table .label {
            text-align: left;
        }

        .totals-table .value {
            text-align: right;
            font-weight: bold;
        }

        .total-line {
            border-top: 1px solid #000;
            border-bottom: 3px double #000;
            font-weight: bold;
        }

        /* -- Footer Notes -- */
        .footer-notes {
            margin-top: 30px;
            font-size: 10px;
            color: #666;
        }

        /* -- Responsive adjustments -- */
        @media print {
            body {
                padding: 10px;
            }
        }

        /* Flexbox fallback for older browsers */
        .address-section::after {
            content: "";
            display: table;
            clear: both;
        }

        .customer-address {
            float: left;
        }

        .invoice-details {
            float: right;
        }

		.item-description {
			color: #000;
			font-size: 12px;
			line-height: 1.4;
			margin: -2px 0 0 0;
			padding: 0;
			white-space: normal;
			word-break: break-word;
		}

		.second-tablee{
			background-color: #e6e6e6;
		}

		.footer-section {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px 30px;
            border-top: 1px solid #E8E8E8;
            background-color: white;
            height: 80px;
        }

        .footer-table {
            width: 100%;
            font-size: 10px;
            line-height: 14px;
            color: #595959;
        }

        .footer-column {
            width: 25%;
            vertical-align: top;
            padding-right: 15px;
        }

        .footer-column strong {
            color: #1D1D1D;
            font-weight: bold;
        }

		.item-details {
			font-size: 9px;
			color: #666;
			margin-top: 3px;
			line-height: 1.2;
		}

    </style>
</head>

<body>
    <!-- Header with Logo -->
    <div class="header-container">
        <div class="logo-container">
             <img class="header-logo" style="height:70px" src="{{ \App\Space\ImageUtils::toBase64Src($logo) }}" alt="Company Logo">
        </div>

        <div class="company-info">
			@php
				$lines = preg_split('/<br\s*\/?>|<\/br>|\r\n|\r|\n/', $company_address);
				$lines = array_map('trim', $lines);

				$line0 = $lines[0] ?? '';
				$line1 = $lines[1] ?? '';
				$line2 = $lines[2] ?? '';

				$line0_plain = strip_tags($line0);

				$companyName = $invoice->customer->company->name;
				$street = trim(str_replace($companyName, '', $line0_plain));


				$city = explode(' ', $line1)[0] ?? '';
				$parts = preg_split('/\s+/', $line2);

				$postcodeParts = preg_split('/\s+/', $line2);
				$postcode = $postcodeParts[1] ?? '';
				$country = $parts[0] ?? '';
			@endphp

            {{ $invoice->customer->company->name }} - {{ $street }} - {{ $city }} - {{ $postcode }} - {{ $country }}
        </div>
    </div>

    <!-- Address and Invoice Details Section -->
    <div class="address-section">
        <div class="customer-address">

			@php
				// Adresse aufteilen
				$lines = preg_split('/<br\s*\/?>|<\/br>|\r\n|\r|\n/', $billing_address);
				$lines = array_map('trim', $lines);

				// Zeilen prüfen
				$line0 = $lines[0] ?? ''; // <h3>Maximilian Wolf</h3>Burgstr. 19
				$line1 = $lines[1] ?? ''; // Eppingen
				$line2 = $lines[2] ?? ''; // Germany 75031

				// 1. Name extrahieren aus <h3>…</h3>
				preg_match('/<h3[^>]*>(.*?)<\/h3>/', $line0, $nameMatch);
				$customer_name = $nameMatch[1] ?? '';

				// 2. Straße = Rest nach dem </h3>
				$customer_address = trim(str_replace($nameMatch[0] ?? '', '', $line0));

				// 3. Stadt = Zeile 1
				$customer_city = $line1;

				// 4. Land und PLZ = aus Zeile 2
				$line2_parts = preg_split('/\s+/', $line2);
				$customer_country = $line2_parts[0] ?? '';
				$customer_postcode = $line2_parts[1] ?? '';
			@endphp

            <div class="name"> {{$customer_name}}</div>
            <div>{{$customer_address}}</div>
            <div>{{$customer_postcode}} {{$customer_city}}</div>
            <div>{{$customer_country}}</div>
			<div>{{ $invoice->customer->base_info }}</div>
        </div>

        <div class="invoice-details">
            <table>
                <tr>
                    <td class="label">Datum</td>
                    <td class="value">{{ $invoice->formattedInvoiceDate }}</td>
                </tr>
               @if (!empty($notes))
					<tr>
						<td class="label">Kunden-Nr:</td>
						<td class="value">{!! $notes !!}</td>
					</tr>
				@endif
                <tr>
                    <td class="label">Rechnungs-Nr:</td>
                    <td class="value">{{ $invoice->invoice_number }}</td>
                </tr>
                <tr>
                    <td class="label">Seite-Nr.</td>
                    <td class="value">1/1</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Invoice Title -->
    <div class="invoice-title">Rechnung</div>
    <div class="invoice-subtitle">Wir erlauben uns folgende Positionen zu berechnen.</div>

    <!-- Items Table -->
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 8%;">Pos.</th>
                <th style="width: 8%;">Menge</th>
                <th style="width: 40%;">Bezeichnung</th>
                <th class="center" style="width: 8%;">       </th>
                <th class="center" style="width: 8%;">% MwSt.</th>
                <th class="right" style="width: 14%;">Einzelpreis</th>
                <th class="right" style="width: 14%;">Gesamtpreis</th>
            </tr>
        </thead>
			<tbody>
				@php
					$items = $invoice->items ?? [];
				@endphp

				@foreach ($items as $index => $item)
					@php
						$rowClass = $index % 2 === 1 ? 'second-tablee' : ''; // class für ungerade Zeilen
						$position = $index + 1;
						$unitPrice = number_format($item->price / 100, 2, ',', '.');
						$totalPrice = number_format(($item->price * $item->quantity) / 100, 2, ',', '.');
					@endphp

					<tr @if($rowClass) class="{{ $rowClass }}" @endif>
						<td class="center">{{ $position }}</td>
						<td class="center">{{ $item->quantity }} x</td>
						<td>
							<div class="item-description">{{ $item->name }}</div>
							@if(!empty($item->description))
								<div class="item-details">{!! nl2br(e($item->description)) !!}</div>
							@endif
						</td>
						<td class="center"></td>
						<td class="center">19%</td>
						<td class="right">{{ $unitPrice }} &#x20AC;</td>
						<td class="right">{{ $totalPrice }} &#x20AC;</td>
					</tr>
			@endforeach
		</tbody>
    </table>

	@php
		$items = $invoice->items ?? [];
		$netto = 0;

		foreach ($items as $item) {
			$netto += ($item->price * $item->quantity) / 100;
		}

		$mwstSatz = 0.19; // 19 % MwSt
		$mwst = $netto * $mwstSatz;
		$brutto = $netto + $mwst;
	@endphp

    <!-- Totals Section -->
    <div class="totals-section">
        <table class="totals-table">
            <tr>
                <td class="label">Nettobetrag</td>
                <td class="value">{{ number_format($netto, 2, ',', '.') }} &#x20AC;</td>
            </tr>
            <tr>
                <td class="label">zzgl. MwSt</td>
                 <td class="value">{{ number_format($mwst, 2, ',', '.') }} &#x20AC;</td>
            </tr>
            <tr class="total-line">
                <td class="label"><strong>Rechnungsbetrag</strong></td>
                <td class="value"><strong>{{ number_format($brutto, 2, ',', '.') }} &#x20AC;</strong></td>
            </tr>
        </table>
    </div>

    <!-- Footer Notes -->
    <div class="footer-notes">
        Zahlbar ohne Abzug bis zum {{ $invoice->formattedDueDate }}.<br>
        Vielen Dank für Ihr Vertrauen und auf weiterhin gute Zusammenarbeit
    </div>

<!-- Footer -->
    <div class="footer-section">
        <table width="100%" class="footer-table">
            <tr>
                <td class="footer-column">
                    <strong>Anschrift</strong><br>
                    {CompanyName}<br>
                    {Street}<br>
                    {postcode} {City}<br><br>
                    GF {GF}
                </td>
                <td class="footer-column">
                    <strong>Kontakt</strong><br>
                    Tel. {number}<br>
                    {email}<br>
                    {web}
                </td>
                <td class="footer-column">
                    <strong>USt-IdNr.</strong><br>
                    {va}
                </td>
                <td class="footer-column">
                    <strong>Bankverbindung</strong><br>
                    {BankeName}<br>
                    {BankOwner}<br>
                    {IBAN}<br>
                    {BIC}
                </td>
            </tr>
        </table>
    </div>

</body>

</html>
