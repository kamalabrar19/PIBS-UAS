<?php
// includes/nav_admin.php
?>
<nav style="
    float: left;               /* Nav mengapung di kiri */
    width: 25%;               /* Lebar Nav 25% */
    background-color: #2c3e50;
    color: #ecf0f1;
    min-height: 600px;        /* Contoh tinggi minimal agar tidak pendek */
    padding: 20px;
    box-sizing: border-box;    /* Pastikan padding dihitung dalam width */
    font-family: Arial, sans-serif;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
">
    <ul style="
        list-style-type: none;
        margin: 0;
        padding: 0;
    ">
        <li style="margin-bottom: 10px;">
            <a href="index.php" style="
                color: #ecf0f1;
                text-decoration: none;
                font-size: 18px;
                display: block;
                padding: 10px;
                transition: background 0.3s, color 0.3s;
            "
            onmouseover="this.style.background='#34495e'; this.style.color='#fff';"
            onmouseout="this.style.background='transparent'; this.style.color='#ecf0f1';">
                Home
            </a>
        </li>
        <li style="margin-bottom: 10px;">
            <a href="surat.php" style="
                color: #ecf0f1;
                text-decoration: none;
                font-size: 18px;
                display: block;
                padding: 10px;
                transition: background 0.3s, color 0.3s;
            "
            onmouseover="this.style.background='#34495e'; this.style.color='#fff';"
            onmouseout="this.style.background='transparent'; this.style.color='#ecf0f1';">
                Surat
            </a>
        </li>
        <li style="margin-bottom: 10px;">
            <a href="../logout.php" style="
                color: #ecf0f1;
                text-decoration: none;
                font-size: 18px;
                display: block;
                padding: 10px;
                transition: background 0.3s, color 0.3s;
            "
            onmouseover="this.style.background='#34495e'; this.style.color='#fff';"
            onmouseout="this.style.background='transparent'; this.style.color='#ecf0f1';">
                Log Out
            </a>
        </li>
    </ul>
</nav>
