<?php
$data = null;
$error = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama = trim($_POST["nama"] ?? "");
    $nim = trim($_POST["nim"] ?? "");
    $prodi = trim($_POST["prodi"] ?? "");
    $semesterInput = $_POST["semester"] ?? "";
    $email = trim($_POST["email"] ?? "");

    if ($nama === "") $error[] = "Nama wajib diisi.";
    if ($nim === "") $error[] = "NIM wajib diisi.";
    if ($prodi === "") $error[] = "Program studi wajib diisi.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = "Format email tidak valid.";
    }
    if (!ctype_digit((string)$semesterInput) ||
        (int)$semesterInput < 1 || (int)$semesterInput > 14) {
        $error[] = "Semester harus berupa angka 1 sampai 14.";
    }

    if (!$error) {
        $data = [
            "nama" => $nama,
            "nim" => $nim,
            "prodi" => $prodi,
            "semester" => (int)$semesterInput,
            "email" => $email
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini Project - Formulir Data Mahasiswa</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f2f5f9; margin: 0; padding: 30px 15px; color: #263238; }
        .container { max-width: 620px; margin: auto; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 18px #00000012; }
        h1 { color: #24527a; margin-top: 0; }
        label { display: block; margin: 14px 0 6px; font-weight: bold; }
        input { width: 100%; padding: 11px; border: 1px solid #cbd5e1; border-radius: 6px; }
        button { margin-top: 18px; padding: 11px 18px; border: 0; border-radius: 6px; background: #24527a; color: white; cursor: pointer; }
        button[type=reset] { background: #64748b; }
        .error { background: #fff1f0; padding: 12px 18px; border-radius: 6px; color: #9f2525; }
        .success { background: #effaf2; padding: 14px; border-radius: 6px; margin-top: 20px; }
    </style>
</head>
<body>
<div class="container">
    <h1>Formulir Data Mahasiswa</h1>
    <p>Silakan isi data mahasiswa dengan benar.</p>

    <form method="POST" action="">
        <label for="nama">Nama Lengkap</label>
        <input id="nama" name="nama" type="text" required>

        <label for="nim">NIM</label>
        <input id="nim" name="nim" type="text" required>

        <label for="prodi">Program Studi</label>
        <input id="prodi" name="prodi" type="text" required>

        <label for="semester">Semester (1–14)</label>
        <input id="semester" name="semester" type="number" min="1" max="14" step="1" required>

        <label for="email">Email</label>
        <input id="email" name="email" type="email" required>

        <button type="submit">Kirim Data</button>
        <button type="reset">Reset</button>
    </form>

    <?php if ($error): ?>
        <div class="error">
            <h3>Data belum dapat diproses:</h3>
            <ul>
                <?php foreach ($error as $pesan): ?>
                    <li><?= htmlspecialchars($pesan, ENT_QUOTES, "UTF-8") ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php elseif ($data !== null): ?>
        <div class="success">
            <h3>Data mahasiswa berhasil diterima</h3>
            <p>Nama: <?= htmlspecialchars($data["nama"], ENT_QUOTES, "UTF-8") ?></p>
            <p>NIM: <?= htmlspecialchars($data["nim"], ENT_QUOTES, "UTF-8") ?></p>
            <p>Program Studi: <?= htmlspecialchars($data["prodi"], ENT_QUOTES, "UTF-8") ?></p>
            <p>Semester: <?= $data["semester"] ?></p>
            <p>Email: <?= htmlspecialchars($data["email"], ENT_QUOTES, "UTF-8") ?></p>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
