//Created by A. Amardeep Upadhyay for CS50 Final Project

//URL Sample http://192.168.1.177:8081/?q=255155100cwp9990512

#include <SPI.h>
#include <Ethernet.h>
#include <Adafruit_NeoPixel.h>
#ifdef __AVR__
  #include <avr/power.h>
#endif

#define PIN 6   //connect neopixel data input to Arduino digital pin #6

Adafruit_NeoPixel strip = Adafruit_NeoPixel(16, PIN, NEO_GRB + NEO_KHZ800);

byte mac[] = {0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED }; //assign arduino mac address
byte ip[] = {192, 168, 1, 177 }; // ip in lan assigned to arduino
byte gateway[] = {192, 168, 1, 1 }; // internet access via router
byte subnet[] = {255, 255, 255, 0 }; //subnet mask
EthernetServer server(8081); //server port arduino server will use
EthernetClient client;
char serverName[] = "www.iflspace.com";
unsigned long lastConnectionTime = 0;             // last time you connected to the server, in milliseconds
const unsigned long postingInterval = 60L * 1000L; // delay between updates, in milliseconds

String readString; //used by server to capture GET request
String red; //red value
String grn; //green value
String blu; //blue value
String eff; //effect to be carried out
String dly; //delay between lights
String rpt; //cycles to repeat
String len; //lenght of the leds to light up for some effects

//int values for the colors
int red_i = 0; 
int grn_i = 0;
int blu_i = 0;
int dly_i = 0;
int rpt_i = 0;
int len_i = 0;


//////////////////////

void setup(){

  pinMode(5, OUTPUT); //pin selected to control

  //pinMode(5, OUTPUT); //pin 5 selected to control
  Ethernet.begin(mac,ip,gateway,gateway,subnet); 
  server.begin();
  Serial.begin(9600); 

  strip.begin();
  strip.show(); // Initialize all pixels to 'off'
  strip.setBrightness(255);

}

void loop(){
  // check for serial input
  if (millis() - lastConnectionTime > postingInterval) {
      sendGET(); // call client sendGET function
  }

  EthernetClient client = server.available();
  if (client) {
    while (client.connected()) {
      if (client.available()) {
        char c = client.read();

        //read char by char HTTP request
        if (readString.length() < 100) {

          //store characters to string 
          readString += c; 
          //Serial.print(c);
        } 

        //if HTTP request has ended
        if (c == '\n') {

          ///////////////
          Serial.print(readString); //print to serial monitor for debuging 

            //now output HTML data header
          client.println("HTTP/1.1 200 OK");
          client.println("Content-Type: text/html");
          client.println();

          delay(1);
          //stopping client
          client.stop();


          //If HTTP request contains a query
          if(readString.indexOf("q") >0)
          {
            for(int i = 8; i <= 26; i++)
            {
                if(i == 8 || i == 9 || i == 10)
                {
                  red += readString.charAt(i);      //Get RGB Red value
                }
                else if(i == 11 || i == 12 || i == 13)
                {
                  grn += readString.charAt(i);     //Get RGB Green value
                }
                else if(i == 14 || i == 15 || i == 16)
                {
                  blu += readString.charAt(i);    //Get RGB Blue value
                }
                else if(i == 17 || i == 18 || i == 19)
                {
                  eff += readString.charAt(i);    //Get the effect to be performed from query string
                }
                else if(i == 20 || i == 21 || i == 22)
                {
                  dly += readString.charAt(i);    //Get desired delay in Microseconds for the particular effect
                }
                else if(i == 23 || i == 24)
                {
                  rpt += readString.charAt(i);    //Number of times the effect must be repeated
                }
                else if(i == 25 || i == 26)
                {
                  len += readString.charAt(i);    //Get Lenght of LEDS for Comet effect
                }
            }

            //Convert string types to int
            red_i = red.toInt();
            grn_i = grn.toInt();
            blu_i = blu.toInt();
            dly_i = dly.toInt();
            rpt_i = rpt.toInt();
            len_i = len.toInt();
            
            //Empty strings to receive new query
            red = "";
            grn = "";
            blu = "";
            dly = "";
            rpt = "";
            len = "";

            //light up
            if(eff == "cwp")
            {
              colorWipe(strip.Color(red_i, grn_i, blu_i), dly_i);
            }
            else if(eff == "trc")
            {
              theaterChase(strip.Color(red_i, grn_i, blu_i), dly_i);
            }
            else if(eff == "rnb")
            {
              rainbow(dly_i);
            }
            else if(eff == "rbc")
            {
              rainbowCycle(dly_i);
            }
            else if(eff == "tcr")
            {
              theaterChaseRainbow(dly_i);
            }
            else if(eff == "glo")
            {
              glow(red_i, grn_i, blu_i, rpt_i);
            }
            else if(eff == "kal")
            {
              kaleidoscope(strip.Color(red_i, grn_i, blu_i), dly_i, rpt_i);
            }
            else if(eff == "cmt")
            {
              comet(red_i, grn_i, blu_i, dly_i, len_i, rpt_i);
            }
            eff = "";
            clear();
          }        
          
          
          //clearing string for next read
          readString="";

        }
      }
    }
  }
} 

//////////////////////////
void sendGET() //client function to send and receive GET data from external server.
{
  if (client.connect(serverName, 80)) {
    Serial.println(F("connected"));
    client.println(F("GET /secretfoldername/secretfilename.php?supersecretip=somethingsomething HTTP/1.1"));
    client.println(F("Host: www.iflspace.com"));
    client.println(F("Connection: close"));
    client.println();

    lastConnectionTime = millis();

  } 
  else {
    Serial.println(F("connection failed"));
    Serial.println();
  }

  while(client.connected() && !client.available()) delay(1); //waits for data
  while (client.connected() || client.available()) { //connected or data available
    char c = client.read();
    Serial.print(c);
  }

  Serial.println();
  Serial.println(F("disconnecting."));
  Serial.println(F("=================="));
  Serial.println();
  client.stop();

}

void colorWipe(uint32_t c, uint8_t wait) {
  for(uint16_t i=0; i<strip.numPixels(); i++) {
    strip.setPixelColor(i, c);
    strip.show();
    delay(wait);
  }
}

void rainbow(uint8_t wait) {
  uint16_t i, j;

  for(j=0; j<256; j++) {
    for(i=0; i<strip.numPixels(); i++) {
      strip.setPixelColor(i, Wheel((i+j) & 255));
    }
    strip.show();
    delay(wait);
  }
}

// Slightly different, this makes the rainbow equally distributed throughout
void rainbowCycle(uint8_t wait) {
  uint16_t i, j;

  for(j=0; j<256*5; j++) { // 5 cycles of all colors on wheel
    for(i=0; i< strip.numPixels(); i++) {
      strip.setPixelColor(i, Wheel(((i * 256 / strip.numPixels()) + j) & 255));
    }
    strip.show();
    delay(wait);
  }
}

//Theatre-style crawling lights.
void theaterChase(uint32_t c, uint8_t wait) {
  for (int j=0; j<10; j++) {  //do 10 cycles of chasing
    for (int q=0; q < 3; q++) {
      for (int i=0; i < strip.numPixels(); i=i+3) {
        strip.setPixelColor(i+q, c);    //turn every third pixel on
      }
      strip.show();

      delay(wait);

      for (int i=0; i < strip.numPixels(); i=i+3) {
        strip.setPixelColor(i+q, 0);        //turn every third pixel off
      }
    }
  }
}

//Theatre-style crawling lights with rainbow effect
void theaterChaseRainbow(uint8_t wait) {
  for (int j=0; j < 256; j++) {     // cycle all 256 colors in the wheel
    for (int q=0; q < 3; q++) {
      for (int i=0; i < strip.numPixels(); i=i+3) {
        strip.setPixelColor(i+q, Wheel( (i+j) % 255));    //turn every third pixel on
      }
      strip.show();

      delay(wait);

      for (int i=0; i < strip.numPixels(); i=i+3) {
        strip.setPixelColor(i+q, 0);        //turn every third pixel off
      }
    }
  }
}

// Input a value 0 to 255 to get a color value.
// The colours are a transition r - g - b - back to r.
uint32_t Wheel(byte WheelPos) {
  WheelPos = 255 - WheelPos;
  if(WheelPos < 85) {
    return strip.Color(255 - WheelPos * 3, 0, WheelPos * 3);
  }
  if(WheelPos < 170) {
    WheelPos -= 85;
    return strip.Color(0, WheelPos * 3, 255 - WheelPos * 3);
  }
  WheelPos -= 170;
  return strip.Color(WheelPos * 3, 255 - WheelPos * 3, 0);
}

//Clears all LEDs
void clear() {
  for (uint16_t i = 0; i < strip.numPixels(); i++) {
    strip.setPixelColor(i, 0, 0, 0);
  }
  strip.show();
}


//Makes a visible glow of given color with increasing and decreasing brightness
//the maximum brightness will be what is specified in setup otherwise it is always 255
void glow(uint32_t r, uint32_t g, uint32_t b, uint8_t repeat){  //Red, Green, Blue, Cycles
  for(uint16_t t= 0; t < repeat; t++){ //Loop for multiple cycles
    for (uint16_t i = 50; i > 0; i--) { //Decrease the brightness
      fill((r/50)*i, (g/50)*i, (b/50)*i);
      delay(20);
    }
    for (uint16_t i = 1; i < 51; i++) { // Increase brightness
    fill((r/50)*i, (g/50)*i, (b/50)*i);
    delay(20);
    }
  }
  for (uint16_t i = 50; i > 0; i--) { //Decrease the brightness
    fill((r/50)*i, (g/50)*i, (b/50)*i);
    delay(20);
  }
}

//LEDs on the opposite end of the ring light up
void kaleidoscope(uint32_t c, uint8_t wait, uint8_t repeat) {
  clear();
  for (uint16_t r = 0; r < 2 * repeat; r++) { //below function lights up half a circle, this line doubles it up making a complete circle
    for (uint16_t i = 0; i < strip.numPixels() / 2; i++) {
      strip.setPixelColor(strip.numPixels() - 1, 0, 0, 0);
      strip.setPixelColor(i, c);
      strip.setPixelColor(i + (strip.numPixels() / 2), c);
      strip.setPixelColor(i - 1, 0, 0 , 0);
      strip.setPixelColor(i + ((strip.numPixels() / 2) - 1), 0, 0, 0);
      strip.show();
      delay(wait);
    }
  }
  clear();
}

//Makes a comet of length given with LEDs getting less brighter as it approaches the tail
void comet(uint32_t r, uint32_t g, uint32_t b, uint8_t wait, uint8_t lenth, uint8_t repeat) { //Red, Green, Blue, Delay, Comet Length
  clear();  //clear the LED array
  int led[lenth];
  uint16_t x;
  uint16_t m;
  uint16_t n;
  for(uint16_t p = 0; p < repeat; p++){   //repeat loop
    for (uint16_t i = 0; i < strip.numPixels(); i++) { //Finishes a full circle
      clear();
      x = 0;
      m = strip.numPixels();
      n = lenth;
      for(uint16_t j = 0; j < lenth; j++){ //Lights up the comet 
        led[j] = i - x;
        x++;
        if(led[j] < 0)     led[j] = i + m;
        strip.setPixelColor(led[j], strip.Color((r / lenth) * n, (g / lenth) * n, (b / lenth) * n));
        n--;
        m--;
      }
      strip.show();
      delay(wait);
      Serial.println(i);
    }
    clear();
  }
}


void fill(uint32_t r, uint32_t g, uint32_t b) {
  for (uint16_t i = 0; i < strip.numPixels(); i++){
    strip.setPixelColor(i, r, g, b);
  }
  strip.show();
}

