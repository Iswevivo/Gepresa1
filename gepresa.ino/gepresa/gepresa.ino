#include <SPI.h>
#include <MFRC522.h>
#include <ESP8266HTTPClient.h>
#include <ESP8266WiFi.h>

#define SS_PIN D4
#define RST_PIN D2

#define ERROR_PIN D0
#define SUCCESS_PIN D1
#define CONN_PIN D8


const char *ssid = "Eugène";            //Nom du WiFi ou point d'accès mobile
const char *password = "isaac@eugene";  //?ot de passse du WiFi ou du point d'accès mobile

// Initialisation des composants
MFRC522 mfrc522(SS_PIN, RST_PIN);
void setup() {
  delay(500);
  Serial.begin(115200);  // Initialiser la vitesse de l'affichage du moniteur série à 115200 bits par secondes
  WiFi.mode(WIFI_OFF);
  delay(500);
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);  // Lancement du processus de connexion au wifi
  Serial.println("");

  // Déclaration des 3 LEDs comme des sorties
  pinMode(CONN_PIN, OUTPUT);
  pinMode(SUCCESS_PIN, OUTPUT);
  pinMode(ERROR_PIN, OUTPUT);

  Serial.print("Connexion en cours");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
    digitalWrite(ERROR_PIN, HIGH);  // La LED rouge est alluméee tant que le nodeMCU n'est pas connecté au WiFi
  }

  Serial.println("");
  Serial.print("Connecté à ");
  Serial.println(ssid);
  Serial.print("Adresse IP du nodeMCU sur ce réseau : ");
  Serial.println(WiFi.localIP());

  SPI.begin();
  mfrc522.PCD_Init();
}

// Envoi de la requête HTTP au serveur avec comme arguments l'UID de la carte et le numéro de la salle
void sendRfidLog(long cardid) {

  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
    WiFiClient client;

    String postData = "cardid=" + String(cardid);
    http.begin(client, "192.168.30.126/gepresa/getUID.php");
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    int httpCode = http.POST(postData);
    String payload = http.getString();

    if (payload.equals("success")) {
      Serial.println("La connexion au serveur a réussi. Réponse = " + httpCode);
    }
      if (httpCode == 200) {

        Serial.println("La requête HTTP s'est bien effectuée. \nRetrour de la requête : " + payload);

        if (payload != 0) {
          Serial.println("Carte non autorisée.");

          //On clignote la LED rouge si la carte n'est pas autorisée (soit elle existe déjà ou n'est pas affectée dans cette salle)
          for (int i = 0; i < 5; i++) {
            digitalWrite(ERROR_PIN, HIGH);
            delay(250);
            digitalWrite(ERROR_PIN, LOW);
            delay(250);
          }
        } else {
          Serial.println("Opération réussie.");

          // On allume la LED rouge si la carte est bien valide
          digitalWrite(SUCCESS_PIN, HIGH);
          delay(250);
          digitalWrite(SUCCESS_PIN, LOW);
          delay(250);
          digitalWrite(SUCCESS_PIN, HIGH);
          delay(250);
          digitalWrite(SUCCESS_PIN, LOW);
          delay(250);
        }
      }else {
        digitalWrite(ERROR_PIN, HIGH);
      }

    http.end();
  }
}

void toggleConnStat() {
  if (WiFi.status() == WL_CONNECTED) {
    // La LED orange demeure allumée tant que le NodeMCU est connecté à un réseau
    digitalWrite(CONN_PIN, HIGH);
    digitalWrite(ERROR_PIN, LOW);
  } else {
    // La LED Rouge demeure allumée tant que le NodeMCU n'est pas connecté à un réseau
    digitalWrite(ERROR_PIN, HIGH);
    digitalWrite(CONN_PIN, LOW);
  }
}

void loop() {

  //Lecture de la carte
  if (mfrc522.PICC_IsNewCardPresent()) {
    if (mfrc522.PICC_ReadCardSerial()) {
      long code = 0;
      for (byte i = 0; i < mfrc522.uid.size; i++) {
        code = ((code + mfrc522.uid.uidByte[i]) * 10);
      }
      // Appel de la fonction sendRfidLog() pour envoyer les données au serveur
      sendRfidLog(code);
    }
  }

  toggleConnStat();
  delay(500);

  digitalWrite(SUCCESS_PIN, LOW);
  digitalWrite(ERROR_PIN, LOW);
}
