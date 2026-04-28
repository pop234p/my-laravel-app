<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Бронирования</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-4">

    <h2>История бронирований</h2>

    <a href="/" class="btn btn-secondary mb-3">На главную</a>

    @foreach($bookings as $b)
        <div class="card mb-3 p-3">

            <h5>{{ $b->car->name }}</h5>

            <p>
                {{ $b->start_date }} → {{ $b->end_date }}
            </p>

            <p>Итого: <b>{{ $b->total_price }} ₽</b></p>

        </div>
    @endforeach

</div>

</body>
</html>