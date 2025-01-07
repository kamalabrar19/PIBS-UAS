<?php
// includes/aside_user.php
?>
<aside style="
    float: right;               
    width: 25%;                 
    background-color: #2c3e50;
    color: #ecf0f1;
    min-height: 600px;          
    padding: 20px;
    box-sizing: border-box;     
    font-family: Arial, sans-serif;
    box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1); 
">
    <h3 style="
        font-size: 22px;
        margin-bottom: 20px;
    ">Informasi Pengguna</h3>

    <p style="font-size: 16px; margin-bottom: 20px;">Selamat datang! Anda dapat menambahkan surat baru menggunakan fitur di bawah ini.</p>
    
    <ul style="
        list-style-type: none;
        margin: 0;
        padding: 0;
    ">
        <li style="margin-bottom: 15px;">
            <a href="surat.php" style="
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
                Tambah Surat Baru
            </a>
        </li>
        <li style="margin-bottom: 15px;">
            <a href="surat.php" style="
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
                Lihat Surat Saya
            </a>
        </li>
    </ul>

    <p style="font-size: 16px; margin-top: 20px;">Jika Anda membutuhkan bantuan, Anda bisa menghubungi admin.</p>
</aside>
