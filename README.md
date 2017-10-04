# SiteProject

Sito che permette la visualizzazione, upload, commento e condivisione di immagini.

03/10/2017 - Creati i file funzionanti di registrazione e accesso al sito.
  -index.php: la pagina di arrivo
  -dbconnection.php: codice per ricevere i dati di accesso al DB che si trovano nel file .htacred
  -signin.html: pagina per l'inserimento delle credenziali per accesso.php
  -accesso.php: controlla che le credenziali siano corrette accedento al DB, in caso affermativo reindirizza alla homepage
  -signup.html: pagina per l'inserimento delle credenziali per registrazione.php
  -registrazione.php :controlla che tutti i campi siano completi ed inserisce tutto nel DB, in caso di successo reindirizza alla   homepage

04/10/2017 - Creato il file home.php contenente l'homepage del sito.
  -Creato il file logOut.php: permette di eseguire il logout dal sito.
  Aggiornamento: aggiornati i file accesso.php, registrazione.php, home.php per includere le sessioni in modo da semplificare il passaggio delle informazioni dell'utente attuale da una pagina all'altra.
