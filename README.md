# AdTech Рекламный Сервис

Проект — рекламная платформа AdTech, реализованная на Laravel, позволяющая рекламодателям создавать офферы, а веб-мастерам подписываться на них и зарабатывать на переходах.

---

## Основные возможности

-   **Роли пользователей:**

    -   Рекламодатель (advertiser)
    -   Веб-мастер (webmaster)

-   **Авторизация и регистрация**

    -   Регистрация и вход с ролью рекламодателя или веб-мастера
    -   Админ-панель с простой авторизацией по паролю из конфига

-   **Управление офферами**

    -   Рекламодатель может создавать, редактировать и удалять офферы
    -   Веб-мастер может подписываться на офферы с настройкой стоимости за клик
    -   Генерация уникальных ссылок для переходов

-   **Статистика и отчёты**

    -   Подсчёт переходов по дням, месяцам и годам
    -   Админка с мониторингом пользователей, доходов и активности

-   **Безопасность**
    -   Хранение паролей с использованием bcrypt
    -   Валидация входных данных
    -   Защита админки паролем из конфигурации

---

## Конфигурация админ-панели

Админ-панель защищена паролем, который задаётся в конфиге config/admin.php:

```
return [
    'password' => env('ADMIN_PASSWORD', 'your-secure-password'),
];
```

## Технологии

> PHP 8+

> Laravel 10

> MySQL / MariaDB

> TailwindCSS (для стилей)

> Blade (шаблонизатор)

> Docker (опционально для запуска)
