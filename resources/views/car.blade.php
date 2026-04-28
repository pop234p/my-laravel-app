<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $car->name }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.8/inputmask.min.js"></script>
</head>

<body class="bg-light">

@include('layouts.header')

<div class="container py-4">

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row">

        <!-- АВТО -->
        <div class="col-md-6 mb-3">

            <div class="card shadow-sm">

                <img src="{{ asset($car->image) }}"
                     class="card-img-top"
                     style="height:300px; object-fit:cover;">

                <div class="card-body">

                    <h3>{{ $car->name }}</h3>

                    <p class="text-muted">{{ $car->category }}</p>

                    <h4 class="text-primary">
                        {{ $car->price_per_day }} ₽ / день
                    </h4>

                </div>

            </div>

        </div>

        <!-- ХАРАКТЕРИСТИКИ -->
        <div class="col-md-6 mb-3">

            <div class="card shadow-sm p-3">

                <h5 class="mb-3">Характеристики</h5>

                <table class="table table-sm">

                    <tr>
                        <td>Двигатель</td>
                        <td>{{ $car->engine ?? '—' }}</td>
                    </tr>

                    <tr>
                        <td>Мощность</td>
                        <td>{{ $car->power ?? '—' }} л.с.</td>
                    </tr>

                    <tr>
                        <td>Коробка</td>
                        <td>{{ $car->transmission ?? '—' }}</td>
                    </tr>

                    <tr>
                        <td>Привод</td>
                        <td>{{ $car->drive_type ?? '—' }}</td>
                    </tr>

                    <tr>
                        <td>Топливо</td>
                        <td>{{ $car->fuel ?? '—' }}</td>
                    </tr>

                    <tr>
                        <td>Год</td>
                        <td>{{ $car->year ?? '—' }}</td>
                    </tr>

                </table>

            </div>

        </div>

    </div>

    <!-- БРОНИРОВАНИЕ -->
    <div class="row">

        <div class="col-md-12">

            <div class="card shadow-sm p-3">

                <h5>Бронирование</h5>

                <form method="POST" action="/book" id="bookingForm">
                    @csrf

                    <input type="hidden" name="car_id" value="{{ $car->id }}">

                    <div class="row">

                        <div class="col-md-4 mb-2">
                            <input type="text"
                                   name="full_name"
                                   class="form-control"
                                   placeholder="Иван Иванов"
                                   required>
                        </div>

                        <div class="col-md-4 mb-2">
                            <input type="text"
                                   name="phone"
                                   id="phone"
                                   class="form-control"
                                   placeholder="+7 (999) 999-99-99"
                                   required>
                        </div>

                        <div class="col-md-2 mb-2">
                            <input type="date"
                                   name="start_date"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="col-md-2 mb-2">
                            <input type="date"
                                   name="end_date"
                                   class="form-control"
                                   required>
                        </div>

                    </div>

                    <textarea name="comment"
                              class="form-control mb-2"
                              placeholder="Комментарий"></textarea>

                    <div class="form-check mb-2">
                        <input type="checkbox"
                               name="insurance"
                               id="insurance"
                               class="form-check-input">

                        <label class="form-check-label">
                            Страховка (+20%)
                        </label>
                    </div>

                    <div class="alert alert-info">
                        Итоговая цена: <span id="totalPrice">—</span> ₽
                    </div>

                    <button class="btn btn-success w-100">
                        Забронировать
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

<script>
const pricePerDay = {{ $car->price_per_day }};

const start = document.querySelector('[name="start_date"]');
const end = document.querySelector('[name="end_date"]');
const insurance = document.querySelector('#insurance');
const total = document.querySelector('#totalPrice');

function calc() {
    if (!start.value || !end.value) return;

    let s = new Date(start.value);
    let e = new Date(end.value);

    let days = (e - s) / (1000 * 60 * 60 * 24);

    if (days <= 0) {
        total.innerText = 'Ошибка дат';
        return;
    }

    let price = days * pricePerDay;

    if (insurance.checked) {
        price += price * 0.2;
    }

    total.innerText = Math.round(price);
}

start.onchange = calc;
end.onchange = calc;
insurance.onchange = calc;

// маска телефона
Inputmask("+7 (999) 999-99-99").mask(document.getElementById("phone"));

// защита дат
document.getElementById('bookingForm').addEventListener('submit', function(e) {
    let s = new Date(start.value);
    let eDate = new Date(end.value);

    if (eDate <= s) {
        e.preventDefault();
        alert('Дата окончания должна быть позже начала');
    }
});
</script>

</body>
</html>