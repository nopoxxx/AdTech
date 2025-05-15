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

    <h2 class="text-xl font-semibold mt-8 mb-2">Доступные офферы</h2>
<table class="min-w-full table-auto mb-6">
    <thead>
        <tr>
            <th class="border px-4 py-2">Название</th>
            <th class="border px-4 py-2">Целевой URL</th>
            <th class="border px-4 py-2">Стоимость</th>
            <th class="border px-4 py-2">Действия</th>
        </tr>
    </thead>
    <tbody>
        @foreach($availableOffers as $offer)
        <tr>
            <td class="border px-4 py-2">{{ $offer->name }}</td>
            <td class="border px-4 py-2">{{ $offer->target_url }}</td>
            <td class="border px-4 py-2">{{ $offer->cost_per_click }}₽ за клик</td>
            <td class="border px-4 py-2 text-sm text-gray-600">
                <form action="{{ route('webmaster.subscribeOffer', $offer->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">
                        Подписаться
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


    <h2 class="text-xl font-semibold mb-2">Ваши подписки</h2>
    <table class="min-w-full table-auto">
        <thead>
            <tr>
                <th class="border px-4 py-2">Offer</th>
                <th class="border px-4 py-2">URL для встраивания</th>
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
                <td class="border px-4 py-2">
                    <button 
                        onclick="copyToClipboard('http://localhost:8080/go/{{ $subscription->custom_url }}')" 
                        class="text-blue-600 underline hover:text-blue-800 focus:outline-none"
                        title="Кликните, чтобы скопировать ссылку">
                        http://localhost:8080/go/{{ $subscription->custom_url }}
                    </button>
                </td>
                <td class="border px-4 py-2">{{ $subscription->offer->cost_per_click }}</td>
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
<script>
    function copyToClipboard(text) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(text)
        } else {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            try {
                document.execCommand('copy');
            } catch (err) {
            }
            document.body.removeChild(textarea);
        }
    }
    </script>
</body>
</html>
