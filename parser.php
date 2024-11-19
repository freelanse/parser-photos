<?php
function downloadFile($url, $savePath) {
    $ch = curl_init();
    $fp = fopen($savePath, 'wb');

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FILE, $fp); // Сохраняем файл сразу
    curl_setopt($ch, CURLOPT_TIMEOUT, 60); // Устанавливаем тайм-аут
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Разрешаем перенаправления
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'); // Указываем User-Agent
    curl_setopt($ch, CURLOPT_FAILONERROR, true); // Считаем ошибкой, если сервер вернул 4xx/5xx

    $success = curl_exec($ch);

    if (curl_errno($ch)) {
        echo "Ошибка при скачивании файла: " . curl_error($ch) . "\n";
    }

    curl_close($ch);
    fclose($fp);

    return $success;
}

// Ссылки на PNG
$links = [
    "https://sites.ru/services1.png",
"https://sites.ru/services2.png"

];

// Папка для сохранения
$saveDir = __DIR__ . '/downloads/'; // указываем путь в папку для сохранения
if (!is_dir($saveDir)) {
    mkdir($saveDir, 0755, true);
}

foreach ($links as $link) {
    $fileName = basename(parse_url($link, PHP_URL_PATH));
    $filePath = $saveDir . $fileName;

    if (downloadFile($link, $filePath)) {
        echo "Файл успешно скачан: $filePath\n";
    } else {
        echo "Не удалось скачать файл: $link\n";
    }
}
