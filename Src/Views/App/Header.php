<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ECLI Details - <?= htmlspecialchars($ecli, ENT_QUOTES, 'UTF-8'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <header class="text-white p-4" style="background: #003399;">
        <div class="container mx-auto max-w-screen-lg flex items-center gap-x-2 px-2">
            <img src="https://curia.chat/assets/scale-curia-small.svg" class="h-12 -mb-2 -mt-2" />
            <h1 class="text-xl font-bold">ECLI Informationen - <?= htmlspecialchars($ecli, ENT_QUOTES, 'UTF-8'); ?></h1>
        </div>
    </header>
    <main class="container mx-auto p-4 max-w-screen-lg">
