<div class="bg-white shadow-md rounded-lg p-6">
    <?php if ($result): ?>
        <!-- Header mit Aktenzeichen, ECLI und Entscheidungsdatum -->
        <div class="mb-4">
            <h2 class="text-xl font-bold mb-2 flex gap-x-2">Entscheidungsdetails</h2>
            <p><strong>Aktenzeichen:</strong> <?= htmlspecialchars($result['case_no'], ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>ECLI:</strong> <?= htmlspecialchars($ecli, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Entscheidungsdatum:</strong> <?= htmlspecialchars($result['date_decided'], ENT_QUOTES, 'UTF-8'); ?></p>
        </div>

        <!-- Abschnitt: Zusammenfassung mit Alpine.js ein-/ausklappbar -->
        <div class="mb-4" x-data="{ expanded: false }">
            <h3 class="text-xl font-semibold mb-2">Zusammenfassung</h3>
            <button @click="expanded = ! expanded" class="text-blue-600 underline">
                <span x-show="!expanded">Zusammenfassung anzeigen</span>
                <span x-show="expanded">Zusammenfassung ausblenden</span>
            </button>
            <p x-show="expanded" x-collapse class="mt-2">
                <?= nl2br(htmlspecialchars($result['text_summary_de'], ENT_QUOTES, 'UTF-8')); ?>
            </p>
        </div>

        <!-- Abschnitt: Vollständiger Text (Markdown in HTML umwandeln) -->
        <div id="fulltext" class="space-y-4 mt-4 border-t-2 border-gray-200 pt-2">
            <h3 class="text-xl font-semibold mb-2">Vollständiger Text (Deutsch)</h3>
            <?php
            // Erstelle eine neue Parsedown-Instanz
            $Parsedown = new Parsedown();

            // Markdown aus der Datenbank in HTML umwandeln
            echo $Parsedown->text($result['text_de']);
            ?>
        </div>

    <?php else: ?>
        <p>Keine Einträge für diesen ECLI gefunden.</p>
    <?php endif; ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Funktion, um den Query-String "q" aus der URL zu extrahieren
        function getQueryStringParameter(name) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        // Den Suchstring "q" aus der URL holen
        const searchQuery = getQueryStringParameter('q');

        // Wenn ein Suchstring vorhanden ist
        if (searchQuery) {
            // Das Element mit dem vollständigen Text holen
            const fullTextElement = document.getElementById('fulltext');

            // Alle <p>-Tags im Element durchsuchen
            const paragraphs = fullTextElement.getElementsByTagName('p');
            let found = false; // Variable, um den ersten gefundenen Absatz zu identifizieren

            // Über alle <p>-Tags iterieren
            for (let i = 0; i < paragraphs.length; i++) {
                let paragraph = paragraphs[i];
                
                // Prüfen, ob der Suchstring im Text des <p>-Tags vorkommt
                if (paragraph.innerText.toLowerCase().includes(searchQuery.toLowerCase())) {
                    // Den gesamten Text des <p>-Tags mit einem <span> umschließen und hervorheben
                    let originalText = paragraph.innerHTML;
                    paragraph.innerHTML = `<span class="bg-yellow-200">${originalText}</span>`;

                    // Wenn dies das erste gefundene Element ist, scrolle animiert zu diesem Bereich
                    if (!found) {
                        const yOffset = -100; // 100px Abstand von oben
                        const y = paragraph.getBoundingClientRect().top + window.pageYOffset + yOffset;

                        window.scrollTo({ top: y, behavior: 'smooth' });
                        found = true;
                    }
                }
            }
        }
    });
</script>
