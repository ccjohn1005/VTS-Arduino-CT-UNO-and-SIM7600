#include <SoftwareSerial.h>
#include "Adafruit_FONA.h"

#define SIMCOM_7600
#define GSM_TX  3
#define GSM_RX  4
#define GSM_PWR 5
#define GSM_RST 20 // Dummy
#define GSM_BAUD  9600

char replybuffer[255];

SoftwareSerial fonaSS = SoftwareSerial(GSM_TX, GSM_RX);
SoftwareSerial *fonaSerial = &fonaSS;

Adafruit_FONA_LTE fona = Adafruit_FONA_LTE();


uint8_t readline(char *buff, uint8_t maxbuff, uint16_t timeout = 0);
char fonaInBuffer[64]; // For notifications from the FONA
char callerIDbuffer[32]; // We'll store the SMS sender number in here
char SMSbuffer[32]; // We'll store the SMS content in here
uint16_t SMSLength;
String SMSString = "";


String SMSSendString = "";
char SMSSendBuffer[80];
float Lat = 0;
float Log = 0;

unsigned long previousMillis;

void setup()
{
  
  delay(2000);
  pinMode(GSM_PWR, OUTPUT);
  delay(1000);
  pinMode(GSM_PWR, INPUT_PULLUP);

  Serial.begin(115200);
//  Serial.println(F("Interfacing SIM7600 GSM GPS Module with Maker UNO"));
  Serial.println(F("Initializing... (May take a minute)"));

  delay(15000);

  // Make it slow so its easy to read!
  fonaSerial->begin(GSM_BAUD);
  if (!fona.begin(*fonaSerial)) {
    Serial.println(F("Couldn't find SIM7600"));
    digitalWrite(LED_BUILTIN, HIGH);

    while (1);
  }
  Serial.println(F("SIM7600 is OK"));

  
//    read the RSSI
    uint8_t n = fona.getRSSI();
    int8_t r;
  
    Serial.print(F("Network Signal RSSI = ")); Serial.print(n); Serial.print(": ");
    if (n == 0) r = -115;
    if (n == 1) r = -111;
    if (n == 31) r = -52;
    if ((n >= 2) && (n <= 30)) {
      r = map(n, 2, 30, -110, -54);
    }
    Serial.print(r); Serial.println(F(" dBm"));
//    fonaSS.print("AT+CNMP=?");
////    fonaSerial->print("AT+CNMP=?\r\n");

    // read the network/cellular status
//    uint8_t m = fona.getNetworkStatus();
//    Serial.print(F("Network status "));
//    Serial.print(m);
//    Serial.print(F(": "));
//    if (m == 0) Serial.println(F("Not registered"));
//    if (m == 1) Serial.println(F("Registered (home)"));
//    if (m == 2) Serial.println(F("Not registered (searching)"));
//    if (m == 3) Serial.println(F("Denied"));
//    if (m == 4) Serial.println(F("Unknown"));
//    if (m == 5) Serial.println(F("Registered roaming"));


  fonaSerial->print("AT+CNMI=2,1\r\n");  // Set up the SIM800L to send a +CMTI notification when an SMS is received
  Serial.println("GSM is ready!");
  delay(12000);

  while (!GPSPositioning()); // Wait until GPS get signal
  Serial.println("GPS is ready!");
  
}


void loop()
{
    uint8_t n = fona.getRSSI();
    int8_t r;
  
    Serial.print(F("Network Signal RSSI = ")); Serial.print(n); Serial.print(": ");
    if (n == 0) r = -115;
    if (n == 1) r = -111;
    if (n == 31) r = -52;
    if ((n >= 2) && (n <= 30)) {
      r = map(n, 2, 30, -110, -54);
    }
    Serial.print(r); Serial.println(F(" dBm"));

    if (fona.available() && r <= -100) {
        char* bufPtr = fonaInBuffer;
        int slot = 0; 
        int charCount = 0;
   
   // Read the notification into fonaInBuffer
    do {
      *bufPtr = fona.read();
      Serial.write(*bufPtr);
      delay(1);
    } while ((*bufPtr++ != '\n') && (fona.available()) && (++charCount < (sizeof(fonaInBuffer) - 1)));

    // Add a terminal NULL to the notification string
    *bufPtr = 0;

    // Scan the notification string for an SMS received notification.
    // If it's an SMS message, we'll get the slot number in 'slot'
    if (1 == sscanf(fonaInBuffer, "+CMTI: \"SM\",%d", &slot)) {
      Serial.print("slot: "); Serial.println(slot);

      // Retrieve SMS sender address/phone number.
      if (!fona.getSMSSender(slot, callerIDbuffer, 31)) {
        Serial.println("Didn't find SMS message in slot!");
      }
      Serial.print("FROM: "); Serial.println(callerIDbuffer);

      if (!fona.readSMS(slot, SMSbuffer, 250, &SMSLength)) { // pass in buffer and max len!
        Serial.println("Failed!");
      }
      else {
        SMSString = String(SMSbuffer);
        Serial.print("SMS: "); Serial.println(SMSString);
      }

      // Compare SMS string
      if (SMSString == "LOCATION") {

        Serial.print("Requesting device location...");
        GPSPositioning();

        delay(100);

        SMSSendString = "VTS:\nhttps://www.fornaxtechnology.com/viewmap.php?vehicleno=ABC1234&latitude=" + String(Lat,7) +"&longtitude=" + String(Log,6)"";
        Serial.println(SMSSendString);

        SMSSendString.toCharArray(SMSSendBuffer, 100);
        // Send SMS for status
        if (!fona.sendSMS(callerIDbuffer, SMSSendBuffer)) {
          Serial.println("Failed");
        }
        else {
          Serial.println(F("Sent!"));
          SMSSendString = "";
        }
      }
      else {
        Serial.print("Invalid command.");
      }

      // Delete the original msg after it is processed
      // otherwise, we will fill up all the slots
      // and then we won't be able to receive SMS anymore
      while (1) {
        boolean deleteSMSDone = fona.deleteSMS(slot);
        if (deleteSMSDone == true) {
          Serial.println("OK!");
          break;
        }
        else {
          Serial.println("Couldn't delete, try again.");
        }
      }
    }

    } else {
            if (millis()-previousMillis > 30000) {
            previousMillis=millis();
            while (postdata());
            Serial.println("GPS Posted! 1 min");
            while (!GPSPositioning());
        } 
    }
}
    

bool postdata(){
    sendATcommand("AT+HTTPINIT", "okay", 1000);
    sendATcommand("AT+HTTPPARA=\"URL\",\"https://www.fornaxtechnology.com/dht.php?latitude=" + String(Lat,6) +"&longtitude=" + String(Log,6)+"\"\r", "OK", 1000);
    sendATcommand("AT+HTTPACTION=2", "OKAY", 1000);  
}



uint8_t sendATcommand(String ATcommand, const char* expected_answer, unsigned int timeout)
{
  uint8_t x = 0, answer = 0;
  char response[100];
  unsigned long previous;

  memset(response, '\0', 100); // Initialize the string

  delay(100);

  while (fonaSerial->available() > 0) { // Clean the input buffer
    fonaSerial->read();
  }

  fonaSerial->println(ATcommand);    // Send the AT command

  x = 0;
  previous = millis();

  // This loop waits for the answer
  do {
    if (fonaSerial->available() != 0) {
      // if there are data in the UART input buffer, reads it and checks for the answer
      response[x] = fonaSerial->read();
      Serial.print(response[x]);
      x++;
      // check if the desired answer is in the response of the module
      if (strstr(response, expected_answer) != NULL) {
        answer = 1;
      }
    }
    // Waits for the asnwer with time out
  } while ((answer == 0) && ((millis() - previous) < timeout));

  // SIM7600Serial->print("\n");
  return answer;
}




bool GPSPositioning()
{
  uint8_t answer = 0;
  bool RecNull = true;
  int i = 0;
  char RecMessage[200];
  char LatDD[3], LatMM[10], LogDD[4], LogMM[10], DdMmYy[7] , UTCTime[7];
  int DayMonthYear;
  Lat = 0;
  Log = 0;

  memset(RecMessage, '\0', 200); // Initialize the string
  memset(LatDD, '\0', 3); // Initialize the string
  memset(LatMM, '\0', 10); // Initialize the string
  memset(LogDD, '\0', 4); // Initialize the string
  memset(LogMM, '\0', 10); // Initialize the string
  memset(DdMmYy, '\0', 7); // Initialize the string
  memset(UTCTime, '\0', 7); // Initialize the string

  Serial.print("Start GPS session...\n");
  sendATcommand("AT+CGPS=1,1", "OK", 2000); // start GPS session, standalone mode
  delay(2000);

  while (RecNull) {
    answer = sendATcommand("AT+CGPSINFO", "+CGPSINFO: ", 1000); // start GPS session, standalone mode

    if (answer == 1) {
      answer = 0;
      while (fonaSerial->available() == 0);

      // this loop reads the data of the GPS
      do {
        // if there are data in the UART input buffer, reads it and checks for the asnwer
        if (fonaSerial->available() > 0) {
          RecMessage[i] = fonaSerial->read();
          i++;
          // check if the desired answer (OK) is in the response of the module
          if (strstr(RecMessage, "OK") != NULL) {
            answer = 1;
          }
        }
      } while (answer == 0);   // Waits for the asnwer with time out

      RecMessage[i] = '\0';
      Serial.print(RecMessage);
      Serial.print("\n");

      if (strstr(RecMessage, ",,,,,,,,") != NULL) {
        memset(RecMessage, '\0', 200);    // Initialize the string
        i = 0;
        answer = 0;
        delay(1000);
      }
      else {
        RecNull = false;
        sendATcommand("AT+CGPS=0", "OK:", 1000);
      }
    }
    else {
      Serial.print("error \n");
      return false;
    }
    delay(2000);
  }

  strncpy(LatDD, RecMessage, 2);
  LatDD[2] = '\0';

  strncpy(LatMM, RecMessage + 2, 9);
  LatMM[9] = '\0';

  Lat = atoi(LatDD) + (atof(LatMM) / 60);
  if (RecMessage[12] == 'N') {
    Serial.print("Latitude is ");
    Serial.print(Lat);
    Serial.print(" N\n");
  }
  else if (RecMessage[12] == 'S') {
    Serial.print("Latitude is ");
    Serial.print(Lat);
    Serial.print(" S\n");
  }
  else {
    return false;
  }

  strncpy(LogDD, RecMessage + 14, 3);
  LogDD[3] = '\0';

  strncpy(LogMM, RecMessage + 17, 9);
  LogMM[9] = '\0';

  Log = atoi(LogDD) + (atof(LogMM) / 60);
  if (RecMessage[27] == 'E') {
    Serial.print("Longitude is ");
    Serial.print(Log);
    Serial.print(" E\n");
  }
  else if (RecMessage[27] == 'W') {
    Serial.print("Latitude is ");
    Serial.print(Lat);
    Serial.print(" W\n");
  }
  else {
    return false;
  }

  strncpy(DdMmYy, RecMessage + 29, 6);
  DdMmYy[6] = '\0';
  Serial.print("Day Month Year is ");
  Serial.print(DdMmYy);
  Serial.print("\n");

  strncpy(UTCTime, RecMessage + 36, 6);
  UTCTime[6] = '\0';
  Serial.print("UTC time is ");
  Serial.print(UTCTime);
  Serial.print("\n");

  return true;
  
}



void flushSerial() {
  while (Serial.available())
    Serial.read();
}
