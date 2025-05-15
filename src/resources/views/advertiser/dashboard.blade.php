<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель управления рекламодателя</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-4">Панель управления рекламодателя</h1>
    <h2 class="text-xl font-semibold mb-2">Создать новый оффер</h2>
    <form action="{{ route('advertiser.createOffer') }}" method="POST" class="bg-white p-6 rounded shadow-lg">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Название оффера</label>
            <input type="text" id="name" name="name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
        </div>

        <div class="mb-4">
            <label for="cost_per_click" class="block text-sm font-medium text-gray-700">Стоимость за клик</label>
            <input type="number" id="cost_per_click" name="cost_per_click" step="0.01" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
        </div>

        <div class="mb-4">
            <label for="target_url" class="block text-sm font-medium text-gray-700">URL назначения</label>
            <input type="url" id="target_url" name="target_url" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
        </div>

        <div class="mb-4">
            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Создать оффер</button>
        </div>
    </form>

    <h2 class="text-xl font-semibold mb-2">Ваши Offers</h2>
    <table class="min-w-full table-auto">
        <thead>
            <tr>
                <th class="border px-4 py-2">Название</th>
                <th class="border px-4 py-2">Стоимость</th>
                <th class="border px-4 py-2">Переходы (День)</th>
                <th class="border px-4 py-2">Переходы (Месяц)</th>
                <th class="border px-4 py-2">Переходы (Год)</th>
                <th class="border px-4 py-2">Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($offers as $offer)
            <tr>
                <td class="border px-4 py-2">{{ $offer->name }}</td>
                <td class="border px-4 py-2">{{ $offer->cost_per_click }}</td>
                <td class="border px-4 py-2">{{ $stats[$offer->id]['daily'] }}</td>
                <td class="border px-4 py-2">{{ $stats[$offer->id]['monthly'] }}</td>
                <td class="border px-4 py-2">{{ $stats[$offer->id]['yearly'] }}</td>
                <td class="border px-4 py-2">
                    @if($offer->status === "active")
                    <form action="{{ route('advertiser.deactivateOffer', $offer->id) }}" method="POST">
                        @csrf
                        @method('POST')
                        <button type="submit" class="bg-red-500 text-white py-1 px-3 rounded">Деактивировать</button>
                    </form>
                    @else
                    <form action="{{ route('advertiser.reactivateOffer', $offer->id) }}" method="POST">
                        @csrf
                        @method('POST')
                        <button type="submit" class="bg-blue-500 text-white py-1 px-3 rounded">Активировать</button>
                    </form>
                    @endif

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
