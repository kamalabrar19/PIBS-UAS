<?php
// includes/aside_admin.php
?>
<aside style="
    float: right;               /* Aside mengapung di kanan */
    width: 25%;                 /* Lebar Aside 25% */
    background-color: #2c3e50;
    color: #ecf0f1;
    min-height: 600px;          /* Tinggi minimal agar tidak pendek */
    padding: 20px;
    box-sizing: border-box;     /* Pastikan padding dihitung dalam width */
    font-family: Arial, sans-serif;
    box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1); /* Bayangan ke kiri */
">
    <h3 style="
        font-size: 22px;
        margin-bottom: 20px;
    ">Informasi Admin</h3>

    <p style="font-size: 16px; margin-bottom: 20px;">Selamat datang, Admin! Anda dapat mengelola data surat melalui fitur berikut.</p>
    
    <ul style="
        list-style-type: none;
        margin: 0;
        padding: 0;
    ">
        <li style="margin-bottom: 15px;">
            <a href="add_surat.php" style="
                color: #ecf0f1;
                text-decoration: none;
                font-size: 18px;
                display: block;
                padding: 10px;
                background-color: #34495e;
                border-radius: 4px;
                transition: background 0.3s, color 0.3s;
            "
            onmouseover="this.style.background='#2c3e50'; this.style.color='#fff';"
            onmouseout="this.style.background='#34495e'; this.style.color='#ecf0f1';">
                Kelola Data Surat
            </a>
        </li>
        <li style="margin-bottom: 15px;">
            <a href="add_surat.php" style="
                color: #ecf0f1;
                text-decoration: none;
                font-size: 18px;
                display: block;
                padding: 10px;
                background-color: #34495e;
                border-radius: 4px;
                transition: background 0.3s, color 0.3s;
            "
            onmouseover="this.style.background='#2c3e50'; this.style.color='#fff';"
            onmouseout="this.style.background='#34495e'; this.style.color='#ecf0f1';">
                Tambah Surat
            </a>
        </li>
        
    </ul>
</aside>
