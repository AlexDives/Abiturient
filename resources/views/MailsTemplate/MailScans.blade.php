<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html style="width:100%;font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0;">
	<head>
		<meta charset="UTF-8">
		<meta content="width=device-width, initial-scale=1" name="viewport">
		<meta content="telephone=no" name="format-detection">
		<title>ЛНУ имени Тараса Шевченко</title>
	</head>
	<body>
		<div>
			<table>
				<tr>
					<td>
						<b>Скайн-копии документов абитуриента {{ $person->famil.' '.$person->name.' '.$person->otch }}</b>
					</td>
				</tr>
				<tr>
					<td>
						<b>Контактные данные:</b><br>
						{{ 'Почта: '.$person->email }}<br>
						{{ $person->phone_one != null ? 'Телефон 1: '.$person->phone_one : '' }}<br>
						{{ $person->phone_two != null ? 'Телефон 2: '.$person->phone_two : '' }}<br>
					</td>
				</tr>
				<tr><td><br></td></tr>
				<tr>
					<td>
						<b>Список документов: </b><br>
						@foreach ($docs as $doc)
							{{ $doc.'; ' }}
						@endforeach
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>