=================================================
CMS Circoli Legambiente Lombardia - Guida utente
=================================================

:author:    Giovanni Biscuolo e Andrea Rota
:address:   Giovanni Biscuolo <g@xelera.eu>, Andrea Rota <a@xelera.eu>
:revision:  1.0
:date:      2013.04.18
:copyright: Copyright © 2013 Semantica di Giovanni Biscuolo.

:abstract:  Il presente documento rappresenta la guida utente per l'utilizzo del CMS dei circoli di Legambiente Lombardia fornito da Xelera. Questa guida illustra specificamente le funzioni aggiuntive rispetto a quelle base di WordPress, di cui si richiama la documentazione e l'help in linea per la guida generale.
            Lombardia

.. sectnum::    :depth: 4

.. contents::   :depth: 4

Introduzione
============

Il CMS per circoli di Legambiente Lombardia fornito da Xelera utilizza WordPress per la gestione dei contenuti pubblicati sul sito di ciascun circolo.

Questo documento non intende essere un manuale utente completo per l'utilizzo di WordPress ma una guida per la gestione dei contenuti specificatamente sviluppati da Xelera per Legambiente Lombardia.

Glossario dei termini utilizzati
=================================

permalink
  è un acronimo per "permanent link" ovverro collegamento permanente. Questo significa che qualsiasi tipo di contenuto (articolo, pagina, ecc.) verrà univocamente identificato all'interno di WordPress e sul web attraverso il suo permalink. Il ``permalink`` viene automaticamente generato e se necessario può essere modificato, anche se in genere è una operazione sconsigliata.

.. Configurazione ambiente di lavoro
.. ===================================

.. profilo utente
.. impostazioni schermo
.. ruoli utenti (e roba specifica tipo niente gestione categorie, solo tag)

Gestione contenuti standard
============================

Per i seguenti tipi di contenuto standard:

* articolo
* pagina
* media
* commenti

forniti da WordPress è a vostra disposizione la funzione di **aiuto in linea** che fornisce tutte le indicazioni in merito ai contenuti che state gestendo. Ove disponibile, trovate la funzione di aiuto in linea premendo sul link ``Aiuto`` posto in alto a destra.

.. ATTENTION::
   Non tutto l'aiuto in linea è stato tradotto in italiano dagli sviluppatori di WordPress ed è disponibile solo in lingua inglese.

Articoli e Pagine
------------------

In aggiunta al contenuto standard, nella sezione ``More Fields`` che trovate in fondo alla pagina è possibile aggiungere uno di questi contenuti speciali:

* ``Video in evidenza``, descritto nel paragrafo `Video`_

* ``Album in evidenza``, descritto nel paragrafo `Album fotografici`_

* ``Rassegna articoli``, descritto nel paragrafo `Raccolta notizie`_

* ``Rassegna pagine``, descritto nel paragrafo `Raccolta pagine`_

Gestione contenuti speciali
===========================

.. Immagine della testata
.. -----------------------
..
.. si può abilitare il ruolo la_editor (o comesichiama) a modificare l'immagine della testata??? se sì spiegare come si fa e quali sono i requisiti dell'immagine (960x200 in JPG).

.. altrimenti va impostata d'ufficio uguele per tutti... si potrà via wp-cli?!?

Eventi
-------


CF7 - Moduli di contatto
-------------------------

Album fotografici
------------------

L'album fotografico rappresenta un **gruppo di foto** che possono essere pubblicate in un articolo o in una pagina. 

.. figure:: images/medium/post-photoalbum-view.png
   :target: images/post-photoalbum-view.png
   :scale: 100 %
   :align: center
   :alt: Album fotografico in un articolo

   Esempio di album fotografico inserito nel corpo di un articolo e come album in evidenza.

Le foto nell'album possono essere selezionate da una e una sole di queste fonti [#]_:

# `Libreria Media``
# set di flickr.com 
# album di picasaweb.com

.. [#] nel caso fossero indicate più fonti verrà scelta la prima inserita 

Le informazioni aggiuntive [#]_ di ciascuna immagine sono prese da ``titolo`` e ``Descrizione``, nel caso si utilizzino immagini nella ``Libreria Media``, oppure dal titolo della foto - se disponibile - nel caso si utilizzino le altre fonti disponibili.

.. [#] visualizzabili dagli utenti quando si preme la ``i`` presente in alto a sinistra nelle immagini

Album fotografico in evidenza
...............................

L'album fotografico in evidenza viene automaticamente visualizzato nella
colonna di destra della pagina o dell'articolo.

Album fotografico inserito nel contenuto
.........................................

È possibile inserire uno o più album fotografici all'interno del contenuto di una pagina o di un articolo, utilizzando il seguente **shortcode**::

 [la_album id='<id_album>']
 
Per indicare quale album fotografico utilizzare occorre speficicare il parametro **id** seguito dal valore del **permalink** dello specifico album fotografico. Ad esempio, per inserire l'album con permalink 'agricoltura', basterà aggiungere questo shortcode::

  [la_album id='agricoltura']

Raccolta notizie
-----------------

.. figure:: images/medium/page-postcollection-view.png
   :target: images/page-postcollection-view.png
   :scale: 100 %
   :align: center
   :alt: Raccolta notizie inserite in una pagina

   Esempio di raccolta notizie (articoli) inserita nel corpo di una pagina e
   come raccolta notizie in evidenza.

Shortcode per la raccolta notizie
..................................

Lo shortcode è::

 [la_raccolta_articoli id='<id_raccolta_articoli>']

Raccolta pagine
----------------

.. figure:: images/medium/page-pagecollection-view.png
   :target: images/page-pagecollection-view.png
   :scale: 100 %
   :align: center
   :alt: Raccolta pagine inserite in una pagina

   Esempio di raccolta pagine inserita nel corpo di una pagina e come raccolta
   pagine in evidenza.


Shortcode per la raccolta pagine
.................................

Lo shortcode è::

 [la_raccolta_pagine id='<id_raccolta_pagine>']


Video
------

.. figure:: images/medium/post-video-view.png
   :target: images/post-video-view.png
   :scale: 100 %
   :align: center
   :alt: Un video inserito in un post

   Esempio di video inserito (embedded) nel corpo di un articolo e come video
   in evidenza.

Shortcode per i video
......................

Lo shortcode è::

 [la_video id='<id_video>']

Petizioni
---------

.. Ulteriore documentazione
.. =========================

.. da valutare ma adesso non ci ho tempo

.. https://codex.wordpress.org è solo in EN ed è un mare magnum nel quale gli utenti utilizzatori si perderebbero

.. https://codex.wordpress.org/Working_with_WordPress è un lago magnum dove gli utilizzatori si perderebbero

.. https://codex.wordpress.org/WordPress_Lessons potrebbe andare ma è solo in EN e forse alcune cose sono outdated tipo i post formats https://codex.wordpress.org/Post_Formats che oggi si chiamano Layout se non sbaglio

..
.. http://en.support.wordpress.com/ : solo in inglese (e potrebbero anche farlela andare bene nel 2013) e orientata principalmente a wordpress.com

.. http://www.html.it/guide/guida-wordpress/ : in italiano ma per una versione vecchia come il cucco, e.g. vedi questo: http://www.html.it/pag/17318/scrivere-un-post-per-il-blog/

.. http://tutorial.altervista.org/wordpress/guida/ le varie pagine che ho visitato a caso sono aggiornate ad Aprile 2011, inoltre mi pare un po' troppo generico nella descrizione delle operazioni e di contro molto orientato a altervista (giustamente)

.. insomma quello della documentazione è - come sempre - un ginepraio nel quale gli sviluppatori si infilano bellamente... zio 'gnorante



