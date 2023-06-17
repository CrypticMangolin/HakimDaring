# HakimDaring
Aplikasi Online Judge untuk Final Proyek PBKK E 2023

### instalasi
1. Untuk instalasi frontend : buka terminal (command prompt) -> pindah ke folder HakimDaring.Client (working directory terminalnya) -> jalankan command ``` npm install ```

2. Untuk instalasi backend : buka terminal (command prompt) -> pindah ke folder HakimDaring.Server -> copy paste file ```.env.example``` menjadi ```.env``` -> jalankan ``` composer install ``` -> jalankan ``` php artisan passport:install ```

3. Instalasi Judge0 : buka terminal (command prompt) -> pindah ke folder judge0-v1.13.0 -> jalankan ```docker compose up -d``` -> tunggu hingga selesai, pastikan memiliki kapasitas 11 GB untuk aplikasi judge0.

### cara menjalankan
1. Untuk menjalankan frontend : buka terminal (command prompt) -> pindah ke folder HakimDaring.Client -> jalankan command ``` npm run dev ``` (perlu menggunakan NodeJs) -> buka alamat ``` localhost:5173 ``` pada internet browser

2. Untuk menajalankan backend : buka terminal (command prompt) -> pindah ke folder HakimDaring.Server -> jalankan ``` php artisan serve ```