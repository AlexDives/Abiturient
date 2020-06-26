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
						<b>Уважаемый (-ая) {{ $person->famil.' '.$person->name.' '.$person->otch }}</b>
					</td>
				</tr>
				<tr>
					<td>Ваши данные прошли проверку и теперь Вам доступно прохождение тестов</td>
				</tr>
				<tr><td><br></td></tr>
            </table>
            <table border="1" cellspacing='0' cellpadding='4'>
                <thead>
                    <th>№</th>
                    <th>Наименование</th>
                    <th>Образовательный уровень</th>
                    <th>Дата и время прохождения</th>
                </thead>
                @foreach ($pers_test as $pt)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $pt->discipline }}</td>
                        <td>{{ $pt->targetAudience_name }}</td>
                        <td>{{ isset($pt->start_time) ? date('d.m.Y H:i', strtotime($pt->start_time)) : '' }}</td>
                    </tr>
                @endforeach
            </table>
		</div>
	</body>
</html>