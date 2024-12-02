# Guida all'integrazione di Firebase per il progetto *PoolSchedule*

## 1. Configurazione del progetto

### 1.1 Creazione del progetto Firebase
1. Vai su [Firebase Console](https://console.firebase.google.com/).
2. Crea un nuovo progetto.
3. Registra l'applicazione Flutter (aggiungi i file di configurazione per Android e iOS).

### 1.2 Aggiungere Firebase al progetto Flutter
1. Installa i pacchetti Flutter necessari:
   - `firebase_core`
   - `firebase_auth`
   - `cloud_firestore`
2. Configura i file di inizializzazione per Android (`google-services.json`) e iOS (`GoogleService-Info.plist`).

### 1.3 Inizializzazione di Firebase in Flutter
```dart
void main() async {
  WidgetsFlutterBinding.ensureInitialized();
  await Firebase.initializeApp();
  runApp(MyApp());
}
```

---

## 2. Autenticazione e registrazione

### 2.1 Setup del backend
- Configura Firebase Authentication per accettare e-mail e password.

### 2.2 Codice Flutter per registrazione
```dart
Future<void> registerUser({
  required String email,
  required String password,
  required Map<String, dynamic> additionalData,
}) async {
  UserCredential userCredential = await FirebaseAuth.instance
      .createUserWithEmailAndPassword(email: email, password: password);

  // Salva i dati aggiuntivi su Firestore
  await FirebaseFirestore.instance
      .collection('users')
      .doc(userCredential.user!.uid)
      .set(additionalData);
}
```
- `additionalData` includerà i brevetti e altre informazioni.

### 2.3 Login dell'utente
```dart
Future<User?> loginUser(String email, String password) async {
  UserCredential userCredential = await FirebaseAuth.instance
      .signInWithEmailAndPassword(email: email, password: password);
  return userCredential.user;
}
```

---

## 3. Gestione dei turni
Utilizza Firestore per gestire i turni.

### 3.1 Modello di dati
- **Utente**:
```json
{
  "id": "uid",
  "nome": "Mario",
  "cognome": "Rossi",
  "email": "mario.rossi@mail.com",
  "brevetti": {
    "AB": true,
    "neonatale": false,
    "baby": false
  },
  "coordinatore": false
}
```

- **Turno**:
```json
{
  "bagninoId": "uid",
  "piscina": "Piscina Centrale",
  "ruolo": "Bagnino",
  "data": "2024-12-01",
  "oraInizio": "08:00",
  "oraFine": "12:00",
  "compenso": 80
}
```

### 3.2 Codice per aggiungere un turno
```dart
Future<void> addTurno(Map<String, dynamic> turno) async {
  await FirebaseFirestore.instance.collection('turni').add(turno);
}
```

### 3.3 Verifica sovrapposizione turni
```dart
Future<bool> isTurnoValid(String bagninoId, DateTime data, String oraInizio, String oraFine) async {
  QuerySnapshot snapshot = await FirebaseFirestore.instance
      .collection('turni')
      .where('bagninoId', isEqualTo: bagninoId)
      .where('data', isEqualTo: data.toIso8601String())
      .get();

  for (var doc in snapshot.docs) {
    DateTime existingStart = DateTime.parse(doc['oraInizio']);
    DateTime existingEnd = DateTime.parse(doc['oraFine']);

    if (!(oraFine.compareTo(existingStart) <= 0 || oraInizio.compareTo(existingEnd) >= 0)) {
      return false; // C'è sovrapposizione
    }
  }
  return true;
}
```

---

## 4. Visualizzazione turni e compensi
Usa i filtri Firestore per mostrare i dati.

### 4.1 Codice esempio
```dart
Stream<List<Map<String, dynamic>>> getTurni(String bagninoId, {int mese, int anno}) {
  return FirebaseFirestore.instance
      .collection('turni')
      .where('bagninoId', isEqualTo: bagninoId)
      .where('data', isGreaterThanOrEqualTo: DateTime(anno, mese, 1).toIso8601String())
      .where('data', isLessThan: DateTime(anno, mese + 1, 1).toIso8601String())
      .snapshots()
      .map((snapshot) =>
          snapshot.docs.map((doc) => doc.data() as Map<String, dynamic>).toList());
}
```

---

## 5. Gestione errori
- Implementa logica di validazione lato frontend prima di salvare su Firebase.
- Usa try-catch per gestire eccezioni durante l'accesso al backend.

---

## 6. Scalabilità futura
Puoi aggiungere funzioni serverless Firebase per:
- Calcolare i compensi.
- Validare i brevetti.
