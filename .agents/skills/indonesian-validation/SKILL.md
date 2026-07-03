---
name: "indonesian-validation"
description: "Ensure Laravel validations are returned in Indonesian by creating lang/id/validation.php and setting APP_LOCALE=id"
---

# Indonesian Validation Rule

When working on this project (E-Apotek) or any other local Indonesian app, ALWAYS ensure that the application's validations and user-facing error messages are in Indonesian.

## Required Actions

1. Check if `APP_LOCALE=id` is set in the `.env` file. If not, set it.
2. Ensure the `lang/id/validation.php` file exists and contains the standard Laravel validation translations (e.g., `required`, `unique`, `max`, `string`, etc.). If the `lang` directory doesn't exist in Laravel 11+, run `php artisan lang:publish` first.
3. If creating custom validation rules or custom Request classes, define the `messages()` method in Indonesian.

By following this skill, we ensure a seamless and localized user experience for Indonesian users, preventing them from seeing raw English errors like "The name has already been taken."
