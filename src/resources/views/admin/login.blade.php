<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход в админ-панель</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <form method="POST" action="{{ route('admin.login') }}" class="bg-white p-6 rounded shadow-md w-80">
        @csrf
        <h2 class="text-2xl font-bold mb-4">Админ вход</h2>

        @error('password')
            <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
        @enderror

        <input
            type="password"
            name="password"
            placeholder="Пароль"
            class="w-full border rounded px-3 py-2 mb-4"
            required
        >

        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
            Войти
        </button>
    </form>
</body>
</html>
