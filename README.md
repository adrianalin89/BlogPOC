Introducere

Cerințele pentru dezvoltarea unui modul custom de blog pentru Magento. Modulul va oferi o funcționalitate simplă de administrare a posturilor de blog în backend și de afișare a acestora în frontend.

Obiective

    Administrare Posturi în Backend: Să permită adăugarea, editarea și ștergerea posturilor de blog.
    Listare Posturi în Frontend: Să afișeze posturile de blog într-o pagină dedicată din frontend.

Cerințe Funcționale

1. Administrare Posturi în Backend

   Creare Posturi: Adminul poate crea posturi noi de blog.
   Campuri necesare: Titlu, Contenut, Autor, Data Publicarii, Status (Publicat/Nepublicat)
   Funcționalitatea de editare WYSIWYG pentru campul de conținut.
   Editare Posturi: Adminul poate edita posturile existente.
   Ștergere Posturi: Adminul poate șterge posturile existente.
   Listare Posturi: Adminul poate vedea o listă a tuturor posturilor existente, cu posibilitatea de a filtra după titlu, autor, data publicării și status.

2. Listare Posturi în Frontend

   Pagina de Blog: O pagină dedicată pentru afișarea posturilor de blog.
   Fiecare post afișat va include titlul, un rezumat al conținutului (primele 200 de caractere), autorul, data publicării și un link către pagina de detalii a postului.
   Pagina de Detalii a Postului: O pagină care afișează conținutul complet al postului.
   Include titlul, conținutul complet, autorul și data publicării.

Cerințe Tehnice

Structura Bazei de Date

    Tabel Posturi de Blog (blog_posts)
    post_id (int, primary key, auto_increment)
    title (varchar, 255)
    slug (varchar, 60)
    content (text)
    author (varchar, 255)
    publish_date (datetime)
    status (enum, 'published', 'unpublished')

Backend (Admin Panel)

    Navigare: Un meniu dedicat în secțiunea de administrare pentru blog, vizibil doar pentru administratorii cu permisiuni adecvate.
    Pagini și Formulare:
        Formular pentru adăugare/editare posturi.
        Pagină pentru listarea posturilor.
    Validare: Validare a câmpurilor de formular (ex. titlul și conținutul să nu fie goale).
    Autorizare: Doar utilizatorii cu rol de admin pot accesa și modifica posturile de blog.

Frontend

    Pagina de Blog: Disponibilă la o adresă URL predefinită (ex. /blog).
    Pagina de Detalii a Postului: Disponibilă la o adresă URL formată din /blog/{slug}.

Cerințe de Dezvoltare

    Compatibilitate: Modulul trebuie să fie compatibil cu Magento 2.4.x.
    Cod Curat și Comentarii: Codul trebuie să fie bine structurat și comentat pentru a fi ușor de întreținut și extins.

Livrabile

    Codul sursă al modulului.
    Documentația modulului (instalare, configurare) - daca este necesar, de preferat in readme.md.

Criterii de Evaluare

    Funcționalitate: Modulul trebuie să îndeplinească toate cerințele funcționale descrise.
    Calitate Cod: Codul trebuie să fie curat, bine structurat și comentat.



