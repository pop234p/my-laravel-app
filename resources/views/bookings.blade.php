<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Мои бронирования - DriveAvto</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<!-- HEADER -->
<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <a href="/" class="navbar-brand fw-bold">DriveAvto</a>

        <div class="d-flex gap-2">
            <a href="/" class="btn btn-light btn-sm">← Назад</a>
        </div>
    </div>
</nav>

<div class="container py-4">

    <h3 class="mb-4">Мои бронирования</h3>

    @if($bookings->isEmpty())
        <div class="alert alert-warning">
            У вас пока нет бронирований
        </div>
    @endif

    @foreach($bookings as $b)

    <div class="card mb-3 shadow-sm">

        <div class="card-body">

            <h5 class="mb-3">
                {{ $b->car->name ?? 'Авто удалено' }}
            </h5>

            <div class="row">

                <div class="col-md-6">

                    <p><b>ФИО:</b>
                        {{ $b->full_name ?? 'Не указано' }}
                    </p>

                    <p><b>Телефон:</b>
                        {{ $b->phone ?? 'Не указан' }}
                    </p>

                    <p><b>Комментарий:</b>
                        {{ $b->comment ?? '-' }}
                    </p>

                </div>

                <div class="col-md-6">

                    <p>
                        📅 {{ $b->start_date }} → {{ $b->end_date }}
                    </p>

                    <p>
                        💰 <b>{{ $b->total_price }} ₽</b>
                    </p>

                    <span class="badge bg-primary">
                        {{ $b->status }}
                    </span>

                </div>

            </div>

        </div>

    </div>

    @endforeach

</div>

</body>
</html>