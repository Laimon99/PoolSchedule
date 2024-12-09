# Backend API Documentation

Questa documentazione descrive le API disponibili per interagire con il backend Laravel. 

## **URL Base**

L'URL per accedere alle API è il seguente (in locale):

http://127.0.0.1:8000/api


Se stai utilizzando un indirizzo IP o un dominio pubblico, sostituisci `127.0.0.1` con l'IP o dominio corrispondente.

---

## **Autenticazione**

Per accedere alle API protette, è necessario includere un header di autenticazione con il token di accesso. Esempio:

Authorization: Bearer <your_token>


Puoi ottenere questo token effettuando il login tramite l'endpoint `/api/login`.

------------------------------------------------------------------------------------------------------------

## **Elenco delle API**

### **1. Autenticazione**

#### **1.1 Login**
- **Metodo:** `POST`
- **Endpoint:** `/api/login`
- **Descrizione:** Effettua il login e restituisce un token di autenticazione.
- **Body esempio:**

  {
    "email": "simone@example.com",
    "password": "password"
  }

Risposta esempio:

{
  "access_token": "your_generated_token_here",
  "token_type": "Bearer",
  "user": {
      "id": 1,
      "name": "Simone",
      "email": "simone@example.com"
  }
}

---

#### **1.2 Logout**
- **Metodo:** `POST`
- **Endpoint:** `/api/logout`
- **Descrizione:** Effettua il logout e invalida il token di autenticazione.

Headers richiesti:

Authorization: Bearer <your_token>

Risposta esempio:

{
  "message": "Logged out successfully"
}

---

1.3 Utente autenticato
Metodo: GET
Endpoint: /api/user
Descrizione: Restituisce i dettagli dell'utente autenticato.
Headers richiesti:

Authorization: Bearer <your_token>

Risposta esempio:

{
  "id": 1,
  "name": "Simone",
  "email": "simone@example.com",
  "email_verified_at": null,
  "created_at": "2024-12-07T16:23:45.000000Z",
  "updated_at": "2024-12-07T16:23:45.000000Z"
}

------------------------------------------------------------------------------------------------------------

2. CRUD API

2.1 Utenti
Lista utenti
Metodo: GET
Endpoint: /api/users
Descrizione: Restituisce tutti gli utenti.
Headers richiesti:
Authorization: Bearer <your_token>

Creazione utente
Metodo: POST
Endpoint: /api/users
Descrizione: Crea un nuovo utente.
Body esempio:


{
  "name": "Simone",
  "email": "simone@example.com",
  "password": "password"
}

---

Dettagli utente
Metodo: GET
Endpoint: /api/users/{id}
Descrizione: Restituisce i dettagli di un utente specifico.
Headers richiesti:

Authorization: Bearer <your_token>

---

Aggiornamento utente
Metodo: PUT
Endpoint: /api/users/{id}
Descrizione: Aggiorna un utente specifico.
Body esempio:

{
  "name": "Simone Updated",
  "email": "simone.updated@example.com"
}

---

Eliminazione utente
Metodo: DELETE
Endpoint: /api/users/{id}
Descrizione: Elimina un utente specifico.
Headers richiesti:

Authorization: Bearer <your_token>

---

2.2 Piscine
Lista piscine
Metodo: GET
Endpoint: /api/pools
Descrizione: Restituisce tutte le piscine.
Headers richiesti:

Authorization: Bearer <your_token>

---

Creazione piscina
Metodo: POST
Endpoint: /api/pools
Descrizione: Crea una nuova piscina.
Body esempio:

{
  "name": "Piscina Comunale",
  "address": "Via Roma 10",
  "coordinator": 1
}

---

Dettagli piscina
Metodo: GET
Endpoint: /api/pools/{id}
Descrizione: Restituisce i dettagli di una piscina specifica.
Headers richiesti:

Authorization: Bearer <your_token>

---

Aggiornamento piscina
Metodo: PUT
Endpoint: /api/pools/{id}
Descrizione: Aggiorna una piscina specifica.

---

Eliminazione piscina
Metodo: DELETE
Endpoint: /api/pools/{id}
Descrizione: Elimina una piscina specifica.
Headers richiesti:

Authorization: Bearer <your_token>

---

2.3 Ruoli

Lista ruoli
Metodo: GET
Endpoint: /api/roles
Descrizione: Restituisce tutti i ruoli.

---

Creazione ruolo
Metodo: POST
Endpoint: /api/roles
Descrizione: Crea un nuovo ruolo.
Body esempio

---

Dettagli ruolo
Metodo: GET
Endpoint: /api/roles/{id}
Descrizione: Restituisce i dettagli di un ruolo specifico.

---

Aggiornamento ruolo
Metodo: PUT
Endpoint: /api/roles/{id}
Descrizione: Aggiorna un ruolo specifico.

---

Eliminazione ruolo
Metodo: DELETE
Endpoint: /api/roles/{id}
Descrizione: Elimina un ruolo specifico.

---

2.4 Turni

Lista turni
Metodo: GET
Endpoint: /api/shifts
Descrizione: Restituisce tutti i turni.

---


Creazione turno
Metodo: POST
Endpoint: /api/shifts
Descrizione: Crea un nuovo turno.
Body esempio:
{
  "id_pools": 1,
  "name_role": "Istruttore",
  "id_users": 1,
  "data": "2024-12-09",
  "oraInizio": "09:00",
  "oraFine": "12:00",
  "compenso": 45.00
}

---


Dettagli turno
Metodo: GET
Endpoint: /api/shifts/{id}
Descrizione: Restituisce i dettagli di un turno specifico.

---


Aggiornamento turno
Metodo: PUT
Endpoint: /api/shifts/{id}
Descrizione: Aggiorna un turno specifico.

---


Eliminazione turno
Metodo: DELETE
Endpoint: /api/shifts/{id}
Descrizione: Elimina un turno specifico.

---


Errore comuni
401 Unauthorized: Token mancante o non valido.
404 Not Found: Risorsa non trovata.
422 Unprocessable Entity: Dati inviati non validi.