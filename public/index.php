<?php
require_once __DIR__ . '/leggidocumentazione.php';
require_once __DIR__ . '/head.php';
$file = $_GET['file'] ?? null;
$cartella = $_GET['cartella'] ?? null;
$cartelleConsentite = [
    'clienti' => __DIR__ . '/asset/documentazione/documentazione_clienti',
    'sviluppatori' => __DIR__ . '/asset/documentazione/documentazione_dev',
];

$contenuto = [];

if ($file !== null && isset($cartelleConsentite[$cartella])) {
    $nomeFile = basename($file);
    $percorsoCartella = realpath($cartelleConsentite[$cartella]);

    // Accetta esclusivamente documenti di testo, non altri file presenti nella cartella.
    if ($nomeFile === $file && preg_match('/\.txt$/i', $nomeFile) && $percorsoCartella !== false) {
        $percorsoFile = realpath($percorsoCartella . DIRECTORY_SEPARATOR . $nomeFile);
        $prefissoConsentito = $percorsoCartella . DIRECTORY_SEPARATOR;

        // realpath() risolve anche i symlink: il file deve restare nella cartella autorizzata.
        if (
            $percorsoFile !== false
            && is_file($percorsoFile)
            && strncmp($percorsoFile, $prefissoConsentito, strlen($prefissoConsentito)) === 0
        ) {
            $contenuto = leggiContenuto($percorsoFile);
        }
    }
}
?>
<header>
 <?php
    require_once __DIR__ . '/nav.php';
?> 
</header>
<div class="container">
<?php 
if($contenuto){
    renderContenuto($contenuto);
} else { ?>
    <main class="home-content">
        <section class="home-intro" aria-labelledby="titolo-home">
            <p class="eyebrow">Documentazione operativa</p>
            <h1 id="titolo-home">Gestionale Ristorante</h1>
            <p class="home-lead">Una soluzione completa per semplificare e organizzare la gestione quotidiana del ristorante.</p>
            <p>Il gestionale permette di gestire in modo centralizzato <strong>tavoli, prenotazioni, menu, ordini, comande, conti e scontrini</strong>, offrendo una visione chiara e immediata dell'attività del locale.</p>
        </section>

        <section class="home-purpose" aria-labelledby="finalita-home">
            <div class="section-marker">01</div>
            <div>
                <h2 id="finalita-home">Finalità</h2>
                <p>L'obiettivo è <strong>ridurre le operazioni manuali, limitare gli errori e rendere più efficiente il servizio</strong>, mettendo a disposizione del personale uno strumento semplice e intuitivo.</p>
                <p>Dalla gestione del tavolo alla chiusura del conto, ogni fase del servizio viene organizzata in un unico sistema, permettendo al personale di lavorare in modo più rapido, preciso e coordinato.</p>
            </div>
        </section>

        <section class="home-features" aria-labelledby="funzioni-home">
            <div class="section-heading">
                <p class="eyebrow">Panoramica</p>
                <h2 id="funzioni-home">Cosa puoi gestire</h2>
            </div>
            <div class="feature-grid">
                <article class="feature-item"><span class="feature-number">01</span><h3>Tavoli</h3><p>Controlla rapidamente la disponibilità e gli ordini associati.</p></article>
                <article class="feature-item"><span class="feature-number">02</span><h3>Prenotazioni</h3><p>Organizza le prenotazioni e assegna i tavoli.</p></article>
                <article class="feature-item"><span class="feature-number">03</span><h3>Menu</h3><p>Gestisci piatti, bevande, prezzi e allergeni.</p></article>
                <article class="feature-item"><span class="feature-number">04</span><h3>Ordini</h3><p>Inserisci e modifica le comande in modo semplice.</p></article>
                <article class="feature-item"><span class="feature-number">05</span><h3>Servizio</h3><p>Organizza gli ordini in base ai diversi momenti del servizio.</p></article>
                <article class="feature-item"><span class="feature-number">06</span><h3>Conti</h3><p>Controlla il riepilogo, applica sconti e gestisci il pagamento.</p></article>
                <article class="feature-item"><span class="feature-number">07</span><h3>Scontrini</h3><p>Emetti, consulta e ristampa gli scontrini.</p></article>
                <article class="feature-item"><span class="feature-number">08</span><h3>Storico</h3><p>Consulta le operazioni effettuate e i relativi dettagli.</p></article>
            </div>
        </section>

        <section class="home-closing" aria-labelledby="strumento-home">
            <p class="eyebrow">Dalla presa dell'ordine alla chiusura</p>
            <h2 id="strumento-home">Un unico strumento per tutto il servizio</h2>
            <p>Il gestionale accompagna il personale durante tutte le fasi operative, mantenendo le informazioni organizzate e facilmente accessibili.</p>
        </section>
    </main>
<?php } ?>
   
</div>
<?php
require_once __DIR__ . '/footer.php';
?>


