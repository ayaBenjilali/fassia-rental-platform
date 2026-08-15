# Fassia

A full-stack peer-to-peer rental marketplace built with Laravel.

Fassia allows users to discover, publish, reserve, and manage rental items through a modern responsive web platform.

## Features

- 🔐 Authentication & user profiles
- 🏠 Rental marketplace
- 🔎 Search & filtering
- 📋 Rental listing management
- 📅 Reservations & dynamic pricing
- 💳 Stripe payments
- 🛒 Shopping cart
- 💬 Internal messaging
- 🔔 Notifications & email alerts
- ⭐ Reviews & ratings
- 📊 User dashboard
- 🛡️ Admin moderation

## Tech Stack

**Backend**
- Laravel 11
- PHP 8.2
- MySQL
- Eloquent ORM

**Frontend**
- Blade
- Tailwind CSS
- Alpine.js
- JavaScript
- Vite

**Integrations**
- Stripe
- Gmail SMTP

## Architecture

```text
Frontend
Blade + Tailwind + Alpine.js
        ↓
Laravel 11 / PHP
        ↓
Eloquent ORM
        ↓
MySQL

External Services:
Stripe + Gmail SMTP
