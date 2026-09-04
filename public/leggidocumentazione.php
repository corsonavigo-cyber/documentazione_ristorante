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
            $etichetta = preg_replace('/^\d+\s*-\s*/', '', pathinfo($file, PATHINFO_FILENAME));
            echo '<li class="listamenu"><a class="menu" href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '">'
                . htmlspecialchars($etichetta, ENT_QUOTES, 'UTF-8')
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
    foreach ($array_righe as $rigaOriginale) {
        if (preg_match('/^\s+v\s*$/i', $rigaOriginale)) {
            continue;
        }

        $rigaOriginale = str_replace('|', '↓', $rigaOriginale);
        $rigaOriginale= str_replace('-->','→',$rigaOriginale);
        $rigaOriginale= str_replace('+','',$rigaOriginale);
        $riga = trim($rigaOriginale);

        if ($riga === '' || preg_match('/^=+$/', $riga) || preg_match('/^-+$/', $riga)) {
            continue;
        }

        $rigaHtml = htmlspecialchars($rigaOriginale, ENT_QUOTES, 'UTF-8');

        if (preg_match('/^\d+\.\s+[A-ZÀ-Ü0-9][A-ZÀ-Ü0-9\s\'.,:&()\/-]*$/u', $riga)) {
            echo '<h2 style="white-space: pre-wrap">' . $rigaHtml . '</h2>';
        } elseif (preg_match('/^PROBLEMA\s*:/i', $riga)) {
            $titolo = preg_replace('/^(\s*)PROBLEMA\s*:\s*/i', '$1', $rigaOriginale);
            echo '<h3 style="white-space: pre-wrap">' . htmlspecialchars($titolo, ENT_QUOTES, 'UTF-8') . '</h3>';
        } elseif (preg_match('/^[^a-zà-öø-ÿ]*[A-ZÀ-ÖØ-Þ][^a-zà-öø-ÿ]*$/u', $riga)) {
            echo '<h4 style="white-space: pre-wrap">' . $rigaHtml . '</h4>';
        }else {
            echo '<p style="white-space: pre-wrap">' . $rigaHtml . '</p>';
        }
    }
}
?>