<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DriveAvto</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

@include('layouts.header')

<div class="container py-4">

    <h2 class="mb-3">Автопарк Ижевск</h2>

    <!-- 🔥 ФИЛЬТР -->
    <form method="GET" class="mb-4">

        <div class="row">

            <div class="col-md-4">

                <select name="price_sort" class="form-select" onchange="this.form.submit()">

                    <option value="">Сортировка по цене</option>
                    <option value="asc" {{ request('price_sort')=='asc'?'selected':'' }}>
                        Сначала дешёвые
                    </option>

                    <option value="desc" {{ request('price_sort')=='desc'?'selected':'' }}>
                        Сначала дорогие
                    </option>

                </select>

            </div>

        </div>

    </form>

    <div class="row">

        @foreach($cars as $car)

        <div class="col-md-4 mb-4">

            <div class="card shadow-sm h-100">

                <img src="{{ asset($car->image) }}"
                     class="card-img-top"
                     style="height:200px; object-fit:cover;">

                <div class="card-body d-flex flex-column">

                    <h5>{{ $car->name }}</h5>

                    <p class="text-muted">{{ $car->category }}</p>

                    <b>{{ $car->price_per_day }} ₽ / день</b>

                    <a href="/car/{{ $car->id }}"
                       class="btn btn-primary mt-3">
                        Подробнее
                    </a>

                </div>

            </div>

        </div>

        @endforeach

    </div>

</div>

</body>
</html>