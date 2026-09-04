<?php

function leggimenu(): void
{
    $cartelle = [
        'clienti' => dirname(__DIR__) . '/documentazione_clienti',
        'sviluppatori' => dirname(__DIR__) . '/documentazione_dev',
    ];

    foreach ($cartelle as $nomeCartella => $percorso) {
        if (!is_dir($percorso)) {
            continue;
        }

        echo '<li class="sezionemenu"><strong>' . htmlspecialchars(ucfirst($nomeCartella), ENT_QUOTES, 'UTF-8') . '</strong><ul>';

        foreach (scandir($percorso) ?: [] as $file) {
            if ($file === '.' || $file === '..' || !is_file($percorso . '/' . $file)) {
                continue;
            }

            $url = '?cartella=' . rawurlencode($nomeCartella) . '&file=' . rawurlencode($file);
            echo '<li class="listamenu"><a class="menu" href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '">'
                . htmlspecialchars(pathinfo($file, PATHINFO_FILENAME), ENT_QUOTES, 'UTF-8')
                . '</a></li>';
        }

        echo '</ul></li>';
    }
}



function leggiContenuto($file): ?array
    {
        try{
            if (!file_exists($file)) {
                throw new \RuntimeException('documentazione non trocvata');
            }

            $handle = fopen($file, 'r');
            if ($handle === false) {
                throw new \Exception('Impossibile aprire la documentazione');
            }
            flock($handle, LOCK_SH); // lock condiviso (shared) — "sto leggendo, aspetta a scrivere"
            $contenuto = stream_get_contents($handle);
            flock($handle, LOCK_UN);  // rilascio il lock
            fclose($handle);

            return array_values(array_filter(
                explode("\n", $contenuto),
                fn(string $riga): bool => trim($riga) !== ''
            ));
            }catch (\Throwable $e){
                echo "errore nel recupero del contenuto";
                return [];
            }

    }

function renderContenuto($array_righe):void{
    foreach ($array_righe as $riga) {
        $riga = trim($riga);

        if ($riga === '' || preg_match('/^=+$/', $riga)) {
            continue;
        }

        $rigaHtml = htmlspecialchars($riga, ENT_QUOTES, 'UTF-8');

        if (preg_match('/^\d+\.\s+/', $riga)) {
            echo '<h2>' . $rigaHtml . '</h2>';
        } else {
            echo '<p>' . $rigaHtml . '</p>';
        }
    }
}
?>