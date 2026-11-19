# Nama Modul
Performance and Bottleneck Tracking System

# Latar Belakang pembuatan modul
Salah satu modul pada proses manajemen Human Resources (HR) di PT Kabayan saat ini masih bersifat reaktif, manual, dan lambat dalam merespons penumpukan pekerja (bottleneck), sehingga menghambat proses pengambilan keputusan oleh manajemen. Untuk mengatasi tantangan tersebut, dikembangkan sebuah sistem HRIS cerdas berbasis PHP Laravel yang dilengkapi dengan fitur perintah suara (voice command) dan otomatisasi alur kerja menggunakan n8n guna mewujudkan sistem pemantauan kinerja yang proaktif dan efisien.

# Permasalahan yang ada 
- Bottleneck Lambat Terdeteksi  
Pimpinan kesulitan mengidentifikasi divisi atau karyawan yang mengalami hambatan kerja secara dini, di mana penumpukan pekerjaan baru diketahui setelah masalah membesar dan proyek terlambat. 

- Monitoring Bersifat Reaktif  
Pengingat tugas yang melewati batas waktu (overdue) masih bergantung sepenuhnya pada pengecekan manual oleh staf HR tanpa adanya sistem terintegrasi yang berjalan otomatis. 

- Navigasi Dasbor Kompleks  
Pimpinan membutuhkan waktu lama untuk membuka dasbor bertingkat atau harus 
meminta staf HR menyusun laporan fisik karena belum tersedianya akses informasi ringkas secara instan. 

- Alur Penanganan Manual yang Panjang 
Proses pengecekan daftar tugas satu persatu, pengiriman pengingat chat, hingga pembuatan surat teguran dan konversi dokumen PDF masih dilakukan secara manual oleh staf HR. 

# Solusi yang akan dibuat
- Integrasi Voice Command (Web Speech API) 
Memungkinkan pimpinan memanggil laporan hambatan secara instan melalui suara tanpa API berbayar, di mana browser mengubah ucapan menjadi parameter query untuk merender grafik (Chart.js) secara real-time. 

- Otomatisasi Latar Belakang dengan n8n 
Memanfaatkan n8n Community Edition (self-hosted Docker) yang aktif setiap pukul 08:00 untuk memindai tugas secara berkala dan menjalankan eskalasi berjenjang (notifikasi Telegram untuk overdue 1–2 hari serta laporan PDF via email untuk overdue ≥3 hari). 

- Transformasi Menjadi Early Warning System 
Mengubah sistem pemantauan dari reaktif menjadi proaktif 24/7 untuk memantau tingkat penyelesaian tugas dan mendeteksi potensi keterlambatan lebih cepat.

# Rencana teknologi yang akan dipakai
- Laravel
- Web Speech API
- Chart.js
- RBAC
- n8n self hosted via docker
- webhook, schedule trigger, IF Node
- Mysql
- SMTP email node + HTML-to-PDF Generator

# Skema Database
1. Tabel users (bawaan Laravel, ditambah kolom RBAC)
    - id - bigint unsigned
    - name - varchar(255)
    - email - varchar(255)
    - email_verified_at - timestamp
    - password - varchar(255)
    - role - enum(director, hr_hod, staff) -- RBAC: director = L1 Full Access, hr_hod = L2 Lead Access, staff = L3 Staff Access
    - employee_id - bigint unsigned, nullable, FK ke employees.id (relasi akun login ke data karyawan untuk scoping data)
    - remember_token - varchar(100)
    - created_at - timestamp
    - updated_at - timestamp

2. Tabel employees
    - id - bigint unsigned
    - nik - varchar(30)
    - name - varchar(100)
    - department - varchar(50) -- diindeks untuk mempercepat agregasi grafik per divisi
    - position - varchar(50)
    - email - varchar(100)
    - telegram_chat_id - varchar(50)
    - status - enum(active,inactive)
    - created_at - timestamp
    - updated_at - timestamp

3. Tabel tasks
    - id - bigint unsigned
    - task_code - varchar(30), unique -- kode unik tugas, contoh: PRJ-2026-081
    - title - varchar(150)
    - project_name - varchar(150) -- nama proyek terkait tugas, contoh: Portal Core Redesign
    - description - text
    - employee_id - bigint unsigned, FK ke employees.id
    - assigned_date - date
    - due_date - date
    - completion_date - date
    - status - enum(pending, in_progress, completed, overdue) -- diindeks bersama due_date untuk mempercepat scan cron n8n jam 08:00
    - created_at - timestamp
    - updated_at - timestamp

4. Tabel bottleneck_logs
    - id - bigint unsigned
    - task_id - bigint unsigned, FK ke tasks.id
    - escalation_level - enum(warning_sent, pdf_generated, resolved)
    - channel_used - varchar(30)
    - message_payload - text
    - created_at - timestamp

5. Tabel voice_query_logs (audit trail fitur Voice Command)
    - id - bigint unsigned
    - user_id - bigint unsigned, nullable, FK ke users.id -- pengguna yang mengucapkan perintah
    - raw_transcript - text -- hasil Speech-to-Text mentah dari browser
    - parsed_intent - varchar(100), nullable -- intent/kata kunci hasil parsing n8n, contoh: overdue_this_week
    - query_params - json, nullable -- parameter hasil parsing n8n untuk query (periode, divisi, dll)
    - result_count - int unsigned, nullable -- jumlah hasil yang dikembalikan ke dashboard
    - created_at - timestamp

# Contoh alur beberapa fitur yang ada pada sistem
1. fitur voice command
    - karyawan/manager menginput task di web
    - sistem menyimpan task ke database
    - HR membuka task di web
    - HR menekan tombol mikrofon dan memberikan instruksi lisan
    - sistem mengkonversi suara menjadi text kemudian mengirim text ke webhook n8n
    - n8n memproses pola kata kunci
    - n8n mengeksekusi query sql secara otomatis ke database
    - sistem menerima response dan merender grafik/tabel

2. fitur bottleneck tracking otomatis (cron job - schedule trigger jam 08:00)
    - n8n memindai database (cek task in progress)
    - ada task yang melewati deadline?
        Jika tidak ada:
        - Selesai
        Jika ada:
        - apakah telat lebih dari 3 hari?
            Jika tidak:
            - n8n mengirim pesan pengingat via telegram
            Jika iya:
            - n8n memicu html-to-pdf untuk membuat surat teguran
            - n8n akan mengirimkan surat ke email yang bersangkutan
            - sistem menyimpan status log pengiriman ke database
            - Selesai