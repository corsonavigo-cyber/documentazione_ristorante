<?php
require_once __DIR__ . '/leggidocumentazione.php';
require_once __DIR__ . '/head.php';
$file = $_GET['file'] ?? null;
$cartella = $_GET['cartella'] ?? null;
$cartelleConsentite = [
    'clienti' => dirname(__DIR__) . '/documentazione_clienti',
    'sviluppatori' => dirname(__DIR__) . '/documentazione_dev',
];

$contenuto = [];

if ($file !== null && isset($cartelleConsentite[$cartella])) {
    $percorsofile = $cartelleConsentite[$cartella] . '/' . basename($file);
    $contenuto = leggiContenuto($percorsofile);
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
} ?> 
   
</div>
<?php
require_once __DIR__ . '/footer.php';
?>


