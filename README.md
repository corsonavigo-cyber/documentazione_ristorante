# Documentazione Ristorante

Portale web per consultare in modo semplice e organizzato la documentazione del gestionale ristorante.

## Contenuti

La documentazione è suddivisa in due sezioni:

- **Clienti**: guide operative per l'accesso al gestionale, la schermata principale, le comande, gli scontrini e la gestione dei problemi comuni.
- **Sviluppatori**: descrizione dell'architettura, delle tecnologie, del backend, delle API, della sicurezza e dei principali flussi applicativi.

Il portale consente di selezionare i documenti dal menu e visualizzarne il contenuto direttamente nel browser.

## Tecnologie

- PHP
- HTML5
- CSS3
- File di testo `.txt` per la documentazione



## Struttura principale

```text
public/
├── index.php
├── nav.php
├── head.php
├── footer.php
├── leggidocumentazione.php
└── asset/
    ├── css/
    ├── img/
    └── documentazione/
        ├── documentazione_clienti/
        └── documentazione_dev/
```
