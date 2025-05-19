<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>AdTech</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-10 rounded-lg shadow-lg max-w-xl text-center">
        <h1 class="text-4xl font-bold mb-6 text-gray-800">Добро пожаловать в AdTech!</h1>
        <p class="text-gray-600 mb-8 text-lg leading-relaxed">
            Этот проект создан для удобной связи между рекламодателями и вебмастерами.
        </p>
        <a href="{{ route('register') }}"
           class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
           Зарегистрироваться
        </a>
    </div>
</body>
</html>
