<h1>Webbskrapa</h1>

<h3>H�r presenterar jag min webbskrapa/bokningssystemet f�r kursen 1DV449</h3>

=========

<h3>Reflektionsfr�gor</h3>

<ul>
<li>Finns det n�gra etiska aspekter vid webbskrapning. Kan du hitta n�got r�ttsfall?</li>
Man ska alltid respektera �garen till hemsidan, om det skulle st� i terms of use att �garen inte vill att man ska skrapa inneh�llet s� ska man l�ta det va.
Det fanns ett fall 2001 d�r ett resebolag hade st�mt en konkurrens f�r att ha skrapat deras priser, i syftet f�r att ha l�gre priser �n konkurrenterna. Fallet lades ner dock d� det inte hade r�ckt av f�retaget att bara s�ga att de inte f�redrog det.<br/>
<li>Finns det n�gra riktlinjer f�r utvecklare att t�nka p� om man vill vara "en god skrapare" mot server�garna?</li>
Man kan t�nka p� att identifiera sig i http headern med en http user agent. Innan man skrapar b�r man �ven kolla igenom Terms of Use och robots.txt filen f�r att se vad �garen av hesidan har f�r "regler". N�got som �ven �r bra att t�nka p� �r att inte �verbelasta originalsidan med en massa st�ndiga anrop, g�ra det i omg�ngar ist�llet.
<li>Begr�nsningar i din l�sning- vad �r generellt och vad �r inte generellt i din kod?</li>
Jag anv�nder mig utav n�gra str�ngberoenden vid till exempel n�r det ska skrivas ut vilken dag eller film som v�rdet i arrayen har. Detta kan inneb�ra problem ifall en till dag eller film skulle l�ggas till. Skrapan �r �ven beroende p� att de svara med ett "ok" och inte n�got annat som ett "X" eller "ja". 
<li>Vad kan robots.txt spela f�r roll?</li>
D� de informerar sekmotorspindlar hur de ska hantera datan s� kan man hindra eventuella o�nskade skrapningar.
</ul
