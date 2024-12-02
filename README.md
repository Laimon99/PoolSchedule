# PoolSchedule

## Dominio applicativo:
Si vuole creare un sistema di gestione ore di lavoro di bagnini e istruttori.

## Schermate:

### Login/registrazione ricevendo in risposta idbagnino
- Dati da inserire per il signup:
    - Nome
    - Cognome
    - Mail
    - Password
    - Brevetto AB (Bool)
    - Brevetto Neonatale (Bool → default=false)
    - Brevetto Baby (Bool → default=false)
    - Brevetto Fitness (Bool → default=false)
    - Brevetto Sport Acqua (Bool → default=false)
    - Brevetto Nuoto (Bool → default=false)
- Restituisci ID

### Inserimento turni
Impostando:
- Data
- Orario di lavoro
- Piscina
- ID bagnino (preso di default dalla login)
- Ruolo
- Compenso?

#### Gestione compenso:
- Calcolare in frontend senza salvarlo nel DB
- Calcolare in frontend ed inviare a DB
- Calcolare in DB

> LAIMON: Lo salverei nel DB per un discorso di comodità per i calcoli dei compensi mensili, per cui bisogna andare a recuperare i dati di tutti i turni. Per quanto riguarda il calcolo non saprei più che altro perché non so come si possa gestire lato backend, io lo calcolerei in frontend in modo tale che anche quando vengono effettuate delle modifiche, si invia anche il nuovo compenso di quel turno.

### Visualizzazione e modifica turni
Visualizzare e modificare i turni con compensi singoli e compenso totale a fine pagina facendo una ricerca con i seguenti filtri (* = Obbligatorio):
- idbagnino* (Inserito in automatico, non dall'utente)
- mese (Default: mese attuale)
- anno (Default: anno attuale)
- piscina (Default: tutte)
- ruolo (Default: tutti)

### Visualizzazione recap guadagni
Visualizzazione dei guadagni degli ultimi `n` mesi.

### Visualizzazione e modifica dati account
Modifica dei dati dell'account e logout.

### Elenco piscine
Elenco piscine con schermate successive con più informazioni per ciascuna piscina (non fondamentale ma da fare più avanti).

## Gestione errori:
- Non è possibile inserire turni che si sovrappongano tra di loro.

## Entità:

- **Utente**:
    - Id
    - Nome
    - Cognome
    - Mail
    - PSW
    - Foto
    - Brevetto AB (Bool)
    - Brevetto Istruttore (Bool → default=true)
    - Brevetto Neonatale (Bool → default=false)
    - Brevetto Baby (Bool → default=false)
    - Brevetto Fitness (Bool → default=false)
    - Brevetto Sport Acqua (Bool → default=false)
    - Brevetto Nuoto (Bool → default=false)
    - Coordinatore (Bool)

- **Ruolo**:
    - Nome
    - Prezzo con brevetto
    - Prezzo senza brevetto

- **Piscina**:
    - Nome
    - Indirizzo
    - Coordinatore
    - Foto

- **Turno**:
    - Bagnino (Utente:id)
    - Piscina (Piscina:Nome)
    - Ruolo (Ruolo:Nome)
    - Data
    - OraInizio
    - OraFine
    - Compenso (per calcolare il booleano del ruolo ricoperto durante il turno, se true prendo il `PrezzoConBrevetto`, altrimenti `PrezzoSenzaBrevetto`, moltiplicato per il totale di ore)

- **Coordinatore**:
    - id
    - nome
    - cognome
    - (ulteriori informazioni)
    - Dovrà essere un utente con poteri particolari, una sorta di admin, quindi probabilmente saranno unite le 2 entità con un booleano che definisce se è coordinatore o meno.

## In futuro:
- Controllo validità brevetti.
