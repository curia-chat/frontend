<?php
namespace Src\Controllers;

use Src\Helper\MySQLHelper;

class ECLIViewController
{
    public function handle($ecli, $config, $searchQuery)
    {
        try {
            // Sicherstellen, dass die ECLI sicher ist
            $safe_ecli = htmlspecialchars($ecli, ENT_QUOTES, 'UTF-8');

            // Datenbankverbindung herstellen mit MySQLHelper
            $pdo = MySQLHelper::getPDO($config);

            // Abfrage aus der Datenbank
            $stmt = $pdo->prepare('SELECT text_de, case_no, text_summary_de, date_decided FROM Judgments WHERE ECLI = :ecli');
            $stmt->execute(['ecli' => $safe_ecli]);
            $result = $stmt->fetch();


            // Header, View und Footer rendern
            $this->render('App/Header', ['ecli' => $safe_ecli]);
            $this->render('ecli_view', ['ecli' => $safe_ecli, 'result' => $result]);
            $this->render('App/Footer');
        } catch (\InvalidArgumentException $e) {
            http_response_code(400);
            echo $e->getMessage();
        } catch (\Exception $e) {
            http_response_code(500);
            echo "Ein unerwarteter Fehler ist aufgetreten.";
        }
    }

    private function render($view, $data = [])
    {
        extract($data);

        $viewFile = __DIR__ . "/../Views/{$view}.php";

        if (file_exists($viewFile)) {
            include($viewFile);
        } else {
            echo "View {$view} nicht gefunden!";
        }
    }
}
