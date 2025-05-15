<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель управления веб-мастера</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-4">Панель управления веб-мастера</h1>

    <h2 class="text-xl font-semibold mb-2">Ваши подписки</h2>
    <table class="min-w-full table-auto">
        <thead>
            <tr>
                <th class="border px-4 py-2">Offer</th>
                <th class="border px-4 py-2">Стоимость</th>
                <th class="border px-4 py-2">Переходы (День)</th>
                <th class="border px-4 py-2">Переходы (Месяц)</th>
                <th class="border px-4 py-2">Переходы (Год)</th>
                <th class="border px-4 py-2">Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subscriptions as $subscription)
            <tr>
                <td class="border px-4 py-2">{{ $subscription->offer->name }}</td>
                <td class="border px-4 py-2">{{ $subscription->cost_per_click }}</td>
                <td class="border px-4 py-2">{{ $stats[$subscription->offer->id]['daily'] }}</td>
                <td class="border px-4 py-2">{{ $stats[$subscription->offer->id]['monthly'] }}</td>
                <td class="border px-4 py-2">{{ $stats[$subscription->offer->id]['yearly'] }}</td>
                <td class="border px-4 py-2">
                    <form action="{{ route('webmaster.unsubscribeOffer', $subscription->offer_id) }}" method="POST">
                        @csrf
                        @method('POST')
                        <button type="submit" class="bg-red-500 text-white py-1 px-3 rounded">Отписаться</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
