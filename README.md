<h2>&nbsp;</h2>
<h1 align="center">You - Smart Personal Lighting Solution<h1>
<h2><b></b>&nbsp;</h2>

<p align="center"><a href="/Pictures/01Featured.jpg"><img title="01 Featured" style="border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px; display: inline" border="0" alt="01 Featured" src="/Pictures/01Featured.jpg" width="1000" height="532"></a> 
<h2><b></b>&nbsp;</h2>
<h2><b>Hardware</b></h2>
<p>This project was inspired by <a href="http://www2.meethue.com/en-in/">Philips Hue Bulbs</a>. But they are costly and therefore I decided to make my own cheap version of it with an Arduino. For this project I have used only three components. 
<p align="center"><a href="/Pictures/02.jpg"><img title="02" style="border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px; display: inline" border="0" alt="02" src="/Pictures/02.jpg" width="620" height="330"></a> </p>
<p>Stacked on top of one another are Arduino and its <a href="https://www.arduino.cc/en/Main/ArduinoEthernetShield">Ethernet shield</a>. The Arduino used here is the genuine one, but the Ethernet shield I used is a cheap Chinese knock-off that I purchased for less than $10. Despite being a knockoff, it worked brilliantly without any problem. The Arduino Ethernet Shield connects the Arduino to the internet in mere minutes. By connecting to the network with an RJ45 cable and little bit of programming, you can start controlling the Arduino from the internet. 
<p align="center"><a href="/Pictures/03.jpg"><img title="03" style="border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px; display: inline" border="0" alt="03" src="/Pictures/03.jpg" width="620" height="330"></a> </p>
<p>The third component I used was a <a href="https://www.adafruit.com/products/1463">NeoPixel Ring</a>. The ring has a 16 ultrabright smart RGB LEDs. I have used this instead of the single RGB LEDs because I initially planned on using at least 5 RGB LEDs and setting them up individually on the breadboard would have been too much of a hassle and I would have had to worry about voltage variation and resistors. This is just a neat option. With this ring, I only need to use on one digital pin on the Arduino to control as many as LEDs in the chain I want. Each LED is addressable as the driver chip is inside the LED. 
<p>&nbsp; <p>&nbsp; <h2><b>Programming</b> </h2>
<p>The project goal I set was to be able to control the NeoPixel ring from anywhere in the world. By controlling I mean being able to control the effect being displayed, color being produced, delay intervals between each LED during an effect and number of cycles the effect should be repeated. When I brought the hardware I had no idea how I was going to achieve this. First thing I had to get familiar with was Arduino, so I connected the ring to the Arduino and started coding. One advantage I had was that the NeoPixel came with a <a href="https://github.com/adafruit/Adafruit_NeoPixel">NeoPixel library for the Arduino</a>. The library came with these three effects already programmed. 
<p>1. ColorWipe (Fill the dots one after the other with a color). 
<p>2. Rainbow (makes a rainbow). 
<p>3. RainbowCycle (Slightly different, this makes the rainbow equally distributed throughout). 
<p>4. TheaterChase (Theatre-style crawling lights). 
<p>So to get familiar with Arduino and its programming, I set about to write my own effects. I ended up writing these three effects in a couple of days. 
<p align="center"><a href="/Pictures/04.png"><img title="04" style="border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px; display: inline" border="0" alt="04" src="/Pictures/04.png" width="739" height="366"></a> </p>
<p>1. Glow (makes a visible glow of given color with increasing and decreasing brightness). 
<p>2. Kaleidoscope (LEDs on the opposite end of the ring light up with a color). 
<p>3. Comet (makes a comet of length given with LEDs getting less brighter as it approaches the tail). 
<p>After I finished with this, I still had no idea how I was going to control the Arduino remotely. All I knew was, I needed the Ethernet shield to connect it to the internet from which I could control it. The Ethernet shield of course came with its own set of Arduino library and from that I found out that when the Ethernet shield was connected to the Arduino, the setup became a webserver and like any webserver, it can be assigned a local IP address and a port. This webserver could then host small webpages and could be accessed locally with that local IP address and port. 
<p align="center"><a href="/Pictures/05.png"><img title="05" style="border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px; display: inline" border="0" alt="05" src="/Pictures/05.png" width="652" height="104"></a> </p>
<p>I didn't really need any webpages to be displayed, but like any webserver this setup could parse HTTP requests and read them, which was what I really needed. So I programmed the webserver to check for any query strings (just the letter “q”) when parsing the HTTP URL request. 
<p align="center"><a href="/Pictures/06.png"><img title="06" style="border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px; display: inline" border="0" alt="06" src="/Pictures/06.png" width="504" height="344"></a> </p>
<p>Then I set about to program my querystring that was just a combination of numbers and some letters, but each one of them means something. 
<p align="center"><a href="/Pictures/07.png"><img title="07" style="border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px; display: inline" border="0" alt="07" src="/Pictures/07.png" width="499" height="34"></a> </p>
<p>I have programmed the query string to behave as such: 
<p>1. First 3 characters (255 here) – The RGB Red value for the color of LED. 
<p>2. Next 3 characters (155 here) – The RGB Green value for the color of LED. 
<p>3. Next 3 characters (100 here) – The RGB Blue Value for the color of LED. 
<p>4. Next 3 characters (cwp here) – The effect to be performed, in this case colorwipe effect. 
<p>5. Next 3 characters (999 here) – The desired delay in Microseconds for the particular effect. 
<p>6. Next 2 characters (05 here) - Number of times the effect must be repeated. 
<p>7. Next 2 characters (12 here) - Get Length of LEDS for Comet effect. 
<p>So when the above URL is accessed from a web browser, color wipe effect with a light orange color starts on the ring. Since the colorwipe has been programmed to only repeat one time, the number of repetitions in the query string does not matter and the LED lengths don't matter here as it only applies to the comet effect. So the program was working perfectly, but only locally. I had to be able to control this thing from anywhere in the world. 
<p>I had a domain name(iflspace.com) lying around, so I decided to use this to remotely control my gadget. Now this site (iflspace.com) proved to be useful for three things. First of all it fulfilled my goal of being able to control this gadget remotely over the internet. Secondly with the site I could design a beautiful user interface, so that I didn't have to input query strings manually each time I had to light up the ring. Thirdly, I was able to polish my web programming skills by using HTML, CSS, Jquery and PHP to design the site. 
<p>The first hurdle I faced in this endeavor was sending http request to the Arduino from my site(iflspace.com). Remember in the above examples, I was able to access this gadget only with my <a href="https://www.iplocation.net/public-vs-private-ip-address">local IP and not a public IP</a>. I was using port 8081 of Arduino to access the webserver. The first thing I had to do was go to my modem settings and set up port forwarding so that any incoming requests to port 8081 will be redirected to my local webserver IP. 
<p align="center"><a href="/Pictures/08.png"><img title="08" style="border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px; display: inline" border="0" alt="08" src="/Pictures/08.png" width="701" height="146"></a> </p>
<p>With this taken care of, I faced another hurdle. My public IP wasn't a static one. I had a dynamic IP. So each time I fired up my computer, I had a different public IP. So I was stuck again as my site(iflspace.com) could no longer send HTTP requests to a single IP over a long time. I had to find some way to inform my site each time my IP changed. It took the longest time to solve this problem during the project. I found a solution in the fact that the Ethernet shield can be used as a web client that could send HTTP requests instead of just receiving them. So I wrote a quick and dirty PHP page on my site(iflspace.com) inside a secret folder that could only be accessed with a specific querystring(so that no user could access it). Inside that PHP page, I used a small php script to get the IP address from where the HTTP request originated (which was my arduino gadget) and save it onto a small file on the server. So whenever that php page was accessed, my public IP address was updated on the site. 
<p align="center"><a href="/Pictures/09.png"><img title="09" style="border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px; display: inline" border="0" alt="09" src="/Pictures/09.png" width="881" height="241"></a> </p>
<p>Now I did face another hurdle here. Since Arduino is just a microcontroller and not a powerful machine, I could just do one process at a time. It couldn't be a webserver and a webclient at the same time. So after a lot of trial and error, I was able to fit a small script into the arduino loop such that once every minute, it would only act as a web client and other times it would act as a web server. So there I had everything in place. 
<p>Only thing left was designing the user interface on iflspace.com, which wasn't much of a hassle. 
<h2><b></b>&nbsp;</h2>
<h2><b></b>&nbsp;</h2>
<h2><b></b>&nbsp;</h2>
