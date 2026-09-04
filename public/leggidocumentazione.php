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
   
    //i sottotitolisono riconoscibili da numerazione decimale con punto, es. 1.1, 1.2, 2.1, 2.2 ecc
    $sottotitoli = preg_grep('/^\d+\.\d+/', $array_righe);
     //i paragrafi sono riconoscibli da spazio prima senza numerazione, es. "Lorem ipsum dolor sit amet, consectetur adipiscing elit."
    $paragrafi= preg_grep('/^\s+/', $array_righe);
    //deve rstituire la stampa del contenuto in html, con sottotitoli in h2 e paragrafi in p
    foreach ($array_righe as $riga){
        if (in_array($riga, $sottotitoli)){
            echo '<h2><strong>'.$riga.'</strong></h2>';
        }elseif (in_array($riga, $paragrafi)){
            echo '<p>'.$riga.'</p>';
        }else{
            echo '<p>'.$riga.'</p>';
        }
    } 
}
?>