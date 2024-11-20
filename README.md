# PoolSchedule

Dominio applicativo:

Si vuole creare un sistema di gestione ore di lavoro di bagnini e istruttori.

Schermate:
-Login/registrazione ricevendo in risposta idbagnino
    -Dati da inserire per signup: Nome, Cognome, Mail, Password, Brevetto AB(Bool), Brevetto istruttore(Bool--> default=false), Brevetto Neonatale(Bool--> default=false),
    Brevetto baby(Bool--> default=false), Brevetto fitness(Bool--> default=false), Brevetto sport acqua(Bool--> default=false), Brevetto nuoto(Bool--> default=false),
    -restituisci ID


-Inserire turni impostando data, orario di lavoro, piscina, id bagnino(preso di default dalla login), ruolo, compenso?.
    => Gestione compenso:
    -Calcolare in frontend senza salvarlo nel db, Calcolare in frontend ed inviare a db, calcolare in db
    -in caso di modifica: Calcolare in frontend senza salvarlo nel db, Calcolare in frontend ed inviare a db, calcolare in db

    LAIMON: Lo salverei nel db per un dicorso di comodità per i calcoli dei compensi mensili per cui bisogna andare a recuperare i dati di tutti i turni, per quanto riguarda il calcolo non saprei piu che altro perchè non so come si possa gestire lato backend, io lo calcolerei in front end in modo tale che anche quando vengono effettuate delle modifiche si invia anche il nuovo compenso di quel turno


-visualizzare e modificare i turni con compensi singoli e compenso totali a fine pagine facendo una ricerca con i seguenti filtri(* = Obbligatorio):
    -idbagnino*(Inserito in automatico, non dall' utente)
    -mese(Default: mese attuale)
    -anno(Default: anno attuale)
    -piscina(Default: tutte)
    -ruolo(Default: tutti)

-Visualizzazione recap guadagni degli ultimi n mesi

-Visualizzazione e modifica dati account e logout

-Elenco piscine con successive schermate con + info per ciascuna piscina //non fondamentale ma da fare piu avanti





GESTIONE ERRORI
-non è possibile inserire turni che si sovrappongano tra di loro

ENTITA:
Utente(Id, Nome, Cognome, Mail, PSW, foto,  Brevetto AB(Bool), Brevetto istruttore(Bool--> default=true), Brevetto Neonatale(Bool--> default=false),
    Brevetto baby(Bool--> default=false), Brevetto fitness(Bool--> default=false), Brevetto sport acqua(Bool--> default=false), Brevetto nuoto(Bool--> default=false), Coordinatore(Bool))
ruolo (Nome, PrezzoConBrevetto, PrezzoSenzaBrevetto)

Piscina(Nome, Indirizzo, Coordinatore, foto)

Turno(Bagnino(Utente:id), Piscina(Piscina:Nome), Ruolo(ruolo:Nome), Data, OraInizio, OraFine, Compenso) ==> per avere il booleano del ruolo ricoperto durante il turno, se true prendo il prezzocoBrevetto altrimenti senza brevetto e lo moltiplico per il totale di ore

Coordinatore(id, nome, cognome e boh....) ==> dovrà essere in realtà un utente con dei poteri particolari, una sorta di admin quindi probabilemente saranno unite le 2 entità mettendo un bool ce definisce se è coordinatore o no


IN FUTURO:
-Controllo validità brevetti

