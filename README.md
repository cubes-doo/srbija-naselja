# Cubes DOO / Srbija Naselja

Ovaj paket pruža osnovnu bazu naselja u Srbiji.

Baza naselja je napravlena na osnovu Wiki stranica sa spiskovima poštanskih brojeva:
[Списак насељених места у Србији](https://sr.wikipedia.org/wiki/%D0%A1%D0%BF%D0%B8%D1%81%D0%B0%D0%BA_%D0%BF%D0%BE%D1%88%D1%82%D0%B0%D0%BD%D1%81%D0%BA%D0%B8%D1%85_%D0%B1%D1%80%D0%BE%D1%98%D0%B5%D0%B2%D0%B0_%D1%83_%D0%A1%D1%80%D0%B1%D0%B8%D1%98%D0%B8)
[Spisak poštanskih brojeva u Srbiji](https://sr.wikipedia.org/sr-el/%D0%A1%D0%BF%D0%B8%D1%81%D0%B0%D0%BA_%D0%BF%D0%BE%D1%88%D1%82%D0%B0%D0%BD%D1%81%D0%BA%D0%B8%D1%85_%D0%B1%D1%80%D0%BE%D1%98%D0%B5%D0%B2%D0%B0_%D1%83_%D0%A1%D1%80%D0%B1%D0%B8%D1%98%D0%B8)

# Dokumentacija

## Instalacija

Instalacija paketa se vrši uobičajno košišćenjem composer-a

```
composer require cubes-doo/srbija-naselja
```

### Integracija sa Laravel 5 framework-om

Paket dolazi sa "ServiceProvider"-om i "Facade"-om za Laravel 5 framework.

Ukoliko koristite Laravel verzije manje od 5.5 morate da ukljucite service provider direktno u `config/app.php`

```
'providers' => [
    ...,
    CubesDoo\SrbijaNaselja\Laravel\ServiceProvider::class,
]

'aliases' => [
    ...,
    'SrbijaNaselja' => CubesDoo\SrbijaNaselja\Laravel\Facade::class,
]
```

## Primeri koriscenja

Celokupno koriscenje paketa se koristi pomicu klase `CubesDoo\SrbijaNaselja\SrbijaNaseljaService`
```
use CubesDoo\SrbijaNaselja\SrbijaNaseljaService as SrbijaNaselja;
```

Ili ako koristite Laravel, pomocu fasade
```
use SrbijaNaselja;
```

Odnosno preko Dependency Injection-a
```
class NekiController
{
    public function nekaAkcija(\CubesDoo\SrbijaNaselja\SrbijaNaseljaService $srbijaNaselja)
}
```


Kada importujete `SrbijaNaselja` servis mozete da koristite njegove metode:

`SrbijaNaselja::naselja()`
Dobija se lista naselja tj niz asocijativnih nizova u formatu:
```
[
    [
        'naselje' => 'Лазаревац',
        'postanski_broj' => 11550,
        'okrug' => 'Град Београд',
        'opstina' => 'Лазаревац',
    ],
    ...
]
```

`SrbijaNaselja::naselje(11550)`
Dobija se naselje na osnovu postanskog broja u formatu:
```
[
    'naselje' => 'Лазаревац',
    'postanski_broj' => 11550,
    'okrug' => 'Град Београд',
    'opstina' => 'Лазаревац',
]
```


`SrbijaNaselja::opstine()`
Dobija se lista opstina tj niz asocijativnih nizova u formatu:
```
[
    [
        'postanski_broj' => 11550,
        'okrug' => 'Град Београд',
        'opstina' => 'Лазаревац',
    ],
    ...
]
```



`SrbijaNaselja::opstina(11550)`
Dobija se opstina na osnovu postanskog broja u formatu:
```
[
    'postanski_broj' => 11550,
    'okrug' => 'Град Београд',
    'opstina' => 'Лазаревац',
]
```

`SrbijaNaselja::okruzi()`
Dobija se lista okruga tj niz string-ova:
```
['Град Београд', 'Јужнобанатски округ', ...]
```

`SrbijaNaselja::okrug(11550)`
Dobija se naziv okruga na osnovu postanskog broja:
```
'Град Београд'
```


### Latinica

Po default-u se daju nazivi na cirilici, ukoliko zelte nazive na latinici, pre opisanih metoda pozovite metodu `latinica`

```
SrbijaNaselja::latinica()->naselja()
```
ili
```
//Prebacite jezink na latinicu
SrbijaNaselja::latinica();
//... 
SrbijaNaselja::naselja(); // na latinici je
SrbijaNaselja::opstine(); //na latinici je 
//...
//Prebacite jezik nazad na cirilicu
SrbijaNaselja::cirilica();
```

*U Laravel-u ukoliko je podesen jezik na 'sr', service provider ce ucitati 'latinicu'!*

## Doprinos paketu

Svako je dobrodošao da pomogne usavršavanju paketa.


### Baza naselja Republike Srbije

Baza naselja je data u vise formata na latinici i ćirilici u fajlovima:

- data/naselja.sr_Cyrl_RS.php - PHP niz sa naseljima na Cirilici
- data/naselja.sr_Cyrl_RS.csv - CSV niz sa naseljima na Cirilici
- data/naselja.sr_RS.php - PHP niz sa naseljima na Latinici
- data/naselja.sr_RS.csv - CSV niz sa naseljima na Latinici

Fajlovi u CSV formatu se ne koriste već su ubačeni radi eventualnog importa ukoliko ima potrebe.

Sami nazivi i postanski brojevi nisu 100% provereni, neophodna je pomoc contributor-a.



### Pokretanje testova

Napisani su PUPUnit testovi za sam servis i za bazu znaja u foldertu `tests`. 
*Ukoliko menjate spomenute fajlove baze obavezno pokrenite testove!!!*

Testovi se pokrecu pomocu komande

```
./vendor/bin/phpunit --bootstrap vendor/autoload.php tests
```

Naravno pre toga morate instalirati neophodne biblioteke.

