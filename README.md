# ✅ OTP Verification System (Laravel + Livewire + Volt + Alpine.js)

A secure One-Time Password (OTP) system built with Laravel 10+, Livewire 3+, Volt, Alpine.js, and TailwindCSS.

---

## 🚀 Installation

Follow these steps to get the project up and running locally:

1. **Clone the repository**:
   ```bash
   https://github.com/dev-rahulb/otp-system-laravel.git
   cd laravel-otp-system
   ```

2. **Install dependencies**:
   ```bash
   composer install
   ```

3. **Configure environment**:
   - Copy `.env.example` to `.env`
     ```bash
     cp .env.example .env
     ```
   - Set your DB credentials in `.env`

4. **Generate app key**:
   ```bash
   php artisan key:generate
   ```

5. **Run migrations**:
   ```bash
   php artisan migrate
   ```

6. **Run the server**:
   ```bash
   php artisan serve
   ```

---

## 🧪 Testing (Manual)
1. Navigate to the OTP page (e.g., `http://localhost:8000/`).
2. Click **"Generate OTP"** – a 6-digit OTP will be displayed.
3. Enter the OTP using the input fields or paste it.
4. ✅ A success or error message will be displayed based on validity.

> Currently there are no PHPUnit/feature tests implemented.

---

## 📌 Assumptions

- Each OTP is **valid for 15 minutes**.

---

## ✨ Additional Features

- 🔒 OTP is saved in DB with expiry & `verified_at` timestamp
- 🎯 Livewire-based real-time validation
- 🔁 Pasting 6-digit OTP auto-triggers verification
- ⌨️ Auto-focus on next input
- 📱 Fully responsive and mobile-friendly UI
- ✅ Digit-only client-side validation

---

## ⚙️ Technical Decisions

- **Livewire + Volt**: For seamless, reactive frontend without writing JS manually.
- **Alpine.js**: For lightweight client-side interactivity (auto-focus, paste, etc.)
- **Tailwind CSS**: For utility-first responsive design.
- **DB storage**: OTPs are stored in a relational table with fields: `user_id`, `code`, `expires_at`, `verified_at`.


---



---

## 📂 Folder Structure Highlights

- `app/Models/OTP.php`: Eloquent model for storing OTP records
- `resources/views/livewire/otp-input.blade.php`: OTP input UI
- `routes/web.php`: Route definition for the OTP screen
- `database/migrations/`: Contains OTP table migration

---

## 📧 Contact

Made by Rahul Bendre.  
If you need help or want custom features, feel free to reach out at `rahul.balu.bendre@gmail.com`.