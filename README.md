# TaskFlow - Laravel Vue Task Manager

TaskFlow is a simple task management web application built with Laravel, Vue, Inertia.js and Tailwind CSS.

This project was created as a practical portfolio project to demonstrate adaptability to the Laravel + Vue ecosystem, applying backend development fundamentals, database modeling, authentication scaffolding and CRUD operations.

## Tech Stack

- PHP
- Laravel
- Vue
- Inertia.js
- Tailwind CSS
- SQLite
- Vite

## Features

- User registration and login
- Authenticated dashboard
- Create tasks
- List user tasks
- Mark tasks as completed
- Delete tasks
- Task status management
- Task priority management
- Due date field
- Server-side validation

## Project Purpose

The purpose of this project is to demonstrate a first functional implementation using Laravel and Vue, aligned with backend and full-stack job requirements.

## Local Setup

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
type nul > database\database.sqlite
php artisan migrate
npm run dev
php artisan serve

## Author

Miguel Ángel Bedoya Montenegro
Full stack Developer with experience in Java, Python, SQL, PHP, Vue and software development fundamentals.