# PoolSchedule

Dominio applicativo:

Si vuole creare un sistema di gestione ore di lavoro di bagnini e istruttori.

Schermate:
-Login/registrazione ricevendo in risposta idbagnino
-Inserire turni impostando data, orario di lavoro, piscina, id bagnino(preso di default dalla login), ruolo.
-visualizzare e modificare i turni con compensi singoli e compenso totali a fine pagine facendo una ricerca con i seguenti filtri(* = Obbligatorio):
    -idbagnino*(Inserito in automatico, non dall' utente)
    -mese(Default: mese attuale)
    -anno(Default: anno attuale)
    -piscina(Default: tutte)
    -ruolo(Default: tutti)

-Visualizzazione recap guadagni degli ultimi n mesi

-Visualizzazione e modifica dati account e logout





GESTIONE ERRORI
-non è possibile inserire turni che si sovrappongano tra di loro

INFORMAZIONI DATI:
ruolo (AB, Neonatale, baby, fitness, sport acqua e nuoto)
con brevetto o senza brevetto non(AB non serve).





Si vuole creare un sistema di gestione ore di lavoro dei bagnini, sono presenti dei turni identificati da data, orario di inizio-fine,  hanno anche la piscina dove viene effettuato e compenso totale del turno lavorativo.
Inserire la possibilitòà di visualizzare i seguenti dati riguardanti il bagnino che ha effettuato il login:
-Totale mensile compensi
-elenco turni, in visualizzazione mensile e settimanale
-elenco turni in base alla piscina

Vincoli di dominio: