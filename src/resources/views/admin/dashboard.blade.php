<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админ-панель</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-50 p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Админ-панель</h1>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                Выйти
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded shadow">
            <p class="text-gray-500">Общий доход</p>
            <p class="text-xl font-semibold">{{ $totalRevenue }} ₽</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <p class="text-gray-500">Выдано ссылок</p>
            <p class="text-xl font-semibold">{{ $totalLinks }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <p class="text-gray-500">Переходов</p>
            <p class="text-xl font-semibold">{{ $totalClicks }}</p>
        </div>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Пользователи</h2>
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Имя</th>
                    <th class="border px-4 py-2">Роль</th>
                    <th class="border px-4 py-2">Действие</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td class="border px-4 py-2">{{ $user->id }}</td>
                    <td class="border px-4 py-2">{{ $user->username }}</td>
                    <td class="border px-4 py-2">{{ $user->role }}</td>
                    <td class="border px-4 py-2">
                        <form method="POST" action="{{route('admin.deactivate', $user)}}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-white px-3 py-1 rounded bg-red-500 hover:bg-red-600">
															Отключить
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
