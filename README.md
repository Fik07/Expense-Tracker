<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

<h2 align="center">🚀 Laravel 12 Starter Kit</h2>

<p align="center">
  A modern Laravel 12 starter application built with authentication, email verification, profile photo upload, and Tailwind CSS — everything you need to start a scalable Laravel project.
</p>

---

<h3>⚙️ Features</h3>

<ul>
  <li>✅ <strong>Laravel Breeze</strong> - Lightweight authentication scaffolding</li>
  <li>🎨 <strong>Tailwind CSS</strong> - Modern, utility-first styling</li>
  <li>📧 <strong>Email Verification</strong> - Built-in verification flow</li>
  <li>🖼️ <strong>Profile Photo Upload</strong> - Image upload and display system</li>
  <li>🐬 <strong>MySQL Integration</strong> - Easily configurable via <code>.env</code></li>
</ul>

---

<h3>🛠️ Getting Started</h3>

<ol>
  <li><strong>Clone the Repository</strong><br>
    <code>git clone https://github.com/your-username/your-repo.git</code><br>
    <code>cd your-repo</code>
  </li>
  <li><strong>Install Backend Dependencies</strong><br>
    <code>composer install</code>
  </li>
  <li><strong>Install Frontend Dependencies</strong><br>
    <code>npm install && npm run build</code>
  </li>
  <li><strong>Configure Environment</strong><br>
    <code>cp .env.example .env</code><br>
    <code>php artisan key:generate</code><br>
    Update your <code>.env</code> with your database and mail credentials.
  </li>
  <li><strong>Run Migrations</strong><br>
    <code>php artisan migrate</code>
  </li>
  <li><strong>Link Storage for Public Access</strong><br>
    <code>php artisan storage:link</code>
  </li>
  <li><strong>Serve the Application</strong><br>
    <code>php artisan serve</code>
  </li>
</ol>

---

<h3>🖼️ Profile Photo Upload</h3>

<p>
  Users can upload a profile photo from their account settings page. The uploaded image is stored at:
</p>

<pre><code>storage/app/public/profile-photos</code></pre>

<p>
  And can be accessed publicly via:
</p>

<pre><code>public/storage/profile-photos</code></pre>

---

<h3>📬 Email Verification</h3>

<p>
  Email verification is enabled by default. Upon registering, users will receive a verification link. For testing, services like <a href="https://mailtrap.io" target="_blank">Mailtrap</a> are recommended.
</p>

---

<h3>🧪 Testing</h3>

<p>To run tests, use:</p>

<pre><code>php artisan test</code></pre>

---

<h3>📄 License</h3>

<p>
  This project is open-sourced under the <a href="https://opensource.org/licenses/MIT" target="_blank">MIT license</a>.
</p>
