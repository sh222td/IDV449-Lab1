<h1>Webbskrapa</h1>

<h3>Här presenterar jag min webbskrapa/bokningssystemet för kursen 1DV449</h3>

=========

<h3>Reflektionsfrågor</h3>

<ul>
<li>Finns det några etiska aspekter vid webbskrapning. Kan du hitta något rättsfall?</li>
Man ska alltid respektera ägaren till hemsidan, om det skulle stå i terms of use att ägaren inte vill att man ska skrapa innehållet så ska man låta det va.
Det fanns ett fall 2001 där ett resebolag hade stämt en konkurrens för att ha skrapat deras priser, i syftet för att ha lägre priser än konkurrenterna. Fallet lades ner dock då det inte hade räckt av företaget att bara säga att de inte föredrog det.<br/>
<li>Finns det några riktlinjer för utvecklare att tänka på om man vill vara "en god skrapare" mot serverägarna?</li>
Man kan tänka på att identifiera sig i http headern med en http user agent. Innan man skrapar bör man även kolla igenom Terms of Use och robots.txt filen för att se vad ägaren av hesidan har för "regler". Något som även är bra att tänka på är att inte överbelasta originalsidan med en massa ständiga anrop, göra det i omgångar istället.
<li>Begränsningar i din lösning- vad är generellt och vad är inte generellt i din kod?</li>
Jag använder mig utav några strängberoenden vid till exempel när det ska skrivas ut vilken dag eller film som värdet i arrayen har. Detta kan innebära problem ifall en till dag eller film skulle läggas till. Skrapan är även beroende på att de svara med ett "ok" och inte något annat som ett "X" eller "ja". 
<li>Vad kan robots.txt spela för roll?</li>
Då de informerar sekmotorspindlar hur de ska hantera datan så kan man hindra eventuella oönskade skrapningar.
</ul
