# Event Management REST API

A RESTful API built with Laravel for managing events and event attendees.

The project demonstrates backend development concepts including REST API design, authentication, authorization, API resources, queues, notifications, scheduled tasks, and rate limiting.

## Features

- Event CRUD operations
- Event attendee management
- Nested API resources
- Scoped route model binding
- Pagination
- API Resources for consistent JSON responses
- Conditional relationship loading using query parameters
- Reusable relationship loading Trait
- Authentication using Laravel Sanctum
- Token-based API authentication
- Authorization using Gates
- Model authorization using Policies
- Custom Artisan commands
- Event reminder notifications
- Email sending
- Queued notifications
- Task scheduling
- API throttling and rate limiting

## Tech Stack

- PHP
- Laravel
- MySQL
- Laravel Sanctum
- Laravel Queues
- Laravel Notifications
- Mailpit
- Postman

## API Endpoints

### Authentication

| Method | Endpoint | Description | Authentication |
|---|---|---|---|
| POST | `/api/login` | Login and receive an API token | Public |
| POST | `/api/logout` | Logout and revoke the token | Required |
| GET | `/api/user` | Get the authenticated user | Required |

### Events

| Method | Endpoint | Description | Authentication |
|---|---|---|---|
| GET | `/api/events` | Get paginated events | Public |
| GET | `/api/events/{event}` | Get a specific event | Public |
| POST | `/api/events` | Create an event | Required |
| PUT/PATCH | `/api/events/{event}` | Update an event | Required |
| DELETE | `/api/events/{event}` | Delete an event | Required |

### Attendees

| Method | Endpoint | Description | Authentication |
|---|---|---|---|
| GET | `/api/events/{event}/attendees` | Get event attendees | Public |
| GET | `/api/events/{event}/attendees/{attendee}` | Get a specific attendee | Public |
| POST | `/api/events/{event}/attendees` | Attend an event | Required |
| DELETE | `/api/events/{event}/attendees/{attendee}` | Remove an attendee | Required |

## Authentication

The API uses Laravel Sanctum for token-based authentication.

After a successful login, the API returns a token:

```json
{
    "token": "your-api-token"
}
```

Send the token with protected requests:

```text
Authorization: Bearer YOUR_TOKEN
```

## Authorization

The project uses Laravel Gates and Policies to control access to protected actions.

Examples include:

- Only authorized users can update events.
- Only authorized users can delete events.
- Event owners and authorized attendees can perform attendee-related actions.

## Conditional Relationship Loading

Relationships can be included dynamically using the `include` query parameter.

Example:

```text
GET /api/events?include=user
```

Multiple relationships:

```text
GET /api/events?include=user,attendees,attendees.user
```

This functionality is handled by a reusable relationship-loading Trait.

## Event Reminders

The project includes a custom Artisan command that finds upcoming events and sends reminder notifications to attendees.

Run the command manually:

```bash
php artisan app:send-event-reminders
```

## Notifications and Email

Event reminders are sent using Laravel Notifications.

During local development, Mailpit can be used as a local SMTP server.

Example local mail configuration:

```env
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
```

Mailpit web interface:

```text
http://localhost:8025
```

## Queues

Notifications are processed asynchronously using Laravel Queues.

Start the queue worker:

```bash
php artisan queue:work
```

If failed jobs need to be retried:

```bash
php artisan queue:retry all
```

## Rate Limiting

Protected API operations and authentication endpoints use Laravel throttling middleware to limit repeated requests.

Example:

```text
5 requests per minute
```

Requests exceeding the configured limit receive:

```text
429 Too Many Requests
```

## Installation

Clone the repository:

```bash
git clone https://github.com/Amjad-Alkahlout/event-management
cd event-management
```

Install PHP dependencies:

```bash
composer install
```

Create the environment file:

```bash
copy .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Configure your database in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=events-management
DB_USERNAME=root
DB_PASSWORD=
```

Run migrations and seed the database:

```bash
php artisan migrate:fresh --seed
```

Start the development server:

```bash
php artisan serve
```

Start the queue worker in another terminal:

```bash
php artisan queue:work
```

## Project Structure

Important parts of the project:

```text
app/
├── Console/Commands
├── Http/
│   ├── Controllers/Api
│   ├── Resources
│   └── Traits
├── Models
├── Notifications
└── Policies

database/
├── factories
├── migrations
└── seeders

routes/
├── api.php
└── console.php
```

## Concepts Demonstrated

This project demonstrates:

- RESTful API design
- Resource controllers
- Nested resources
- Route model binding
- Eloquent relationships
- Database factories and seeders
- API Resources
- Pagination
- Authentication
- Authorization
- Custom Artisan commands
- Task scheduling
- Notifications
- Email delivery
- Background queues
- API throttling

## License

This project is open-source and available under the MIT License.
