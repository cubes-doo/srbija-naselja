<?php

namespace CubesDoo\SrbijaNaselja;

class BazaArray implements BazaInterface
{
    /**
     * @var string
     */
    protected $lang;

    /**
     * @var array
     */
    protected $naselja;

    /**
     * @var array
     */
    protected $opstine;

    /**
     * @var array
     */
    protected $okruzi;

    public function __construct(string $lang = 'sr_Cyrl_RS')
    {
        $this->lang($lang);
    }

    /**
     * @param string $lang - Setuje se jezik za bazu naselja po kome ce se dobijati rezultati
     */
    public function lang(string $lang)
    {
        return $this->setLang($lang);
    }

    /**
     * Vraca se niz asocijativnih nizova u formatu
     * [
     *      'naselje'        => string, // naziv naselja / mesta
     *      'postanski_broj' => int,    // postanski broj nasleja / mesta
     *      'okrug'          => string, // naziv okruga
     *      'opstina'        => string, // naziv opstine
     * ]
     * @return array
     */
    public function naselja()
    {
        return $this->getNaselja();
    }

    /**
     * Trazi se naselje na osnovu postanskog broj
     * @param scalar $postanskiBroj
     * @return array|null Ako naselje nije pronacjeno NULL, u suprotnom Niz sa podacima o naselju u formatu
     * [
     *      'naselje'        => string, // naziv naselja / mesta
     *      'postanski_broj' => int,    // postanski broj naselja / mesta
     *      'okrug'          => string, // naziv okruga
     *      'opstina'        => string, // naziv opstine
     * ]
     */
    public function naselje($postanskiBroj)
    {
        if (!is_scalar($postanskiBroj) || empty($postanskiBroj)) {
            throw new \InvalidArgumentException('Argument $postanski broj mora da bude skalar koji nije prazan');
        }

        foreach ($this->naselja() as $naselje) {
            if ($naselje['postanski_broj'] == $postanskiBroj) {
                return $naselje;
            }
        }
        return null;
    }

    /**
     * Vraca se niz asocijativnih nizova u formatu
     * [
     *      'postanski_broj' => int,    // postanski broj opstine
     *      'okrug'          => string, // naziv okruga
     *      'opstina'        => string, // naziv opstine
     * ]
     * @return array
     */
    public function opstine()
    {
        return $this->opstine;
    }

    /**
     * 
     * @param scalar $postanskiBroj
     * @return array|null Ako opstina nije pronadjena NULL, u suprotnom Niz sa podacima o opstini u formatu
     * [
     *      'postanski_broj' => int,    // postanski broj opstine
     *      'okrug'          => string, // naziv okruga
     *      'opstina'        => string, // naziv opstine
     * ]
     */
    public function opstina($postanskiBroj)
    {
        if (!is_scalar($postanskiBroj) || empty($postanskiBroj)) {
            throw new \InvalidArgumentException('Argument $postanski broj mora da bude skalar koji nije prazan');
        }

        foreach ($this->opstine() as $opstina) {
            if ($opstina['postanski_broj'] == $postanskiBroj) {
                return $opstina;
            }
        }

        //nije pronadjena opstina po postanskom broju, treba pretraziti naselja i njihove opstine

        $naselje = $this->naselje($postanskiBroj);

        foreach ($this->opstine() as $opstina) {
            if (
                $naselje['opstina'] == $opstina['opstina']
                // postanski broj takodje mora da se slaze u prve dve cifre jer postoje opstine sa istim imenom
                && \abs($naselje['postanski_broj'] - $opstina['postanski_broj']) <= 1000
            ) {
                return $opstina;
            }
        }

        return null;
    }

    /**
     * Vraca se niz stringova sa nazivima okruga po azbucnom redu
     * @return string[]
     */
    public function okruzi()
    {
        return $this->okruzi;
    }


    /**
     * @param scalar $postanskiBroj
     * @return string|null Ako okrug nije pronadjen NULL, u suprotnom string sa nazivom okruga
     */
    public function okrug($postanskiBroj)
    {
        $opstina = $this->opstina($postanskiBroj);

        if (!$opstina) {
            return null;
        }

        return $opstina['okrug'];
    }

    /**
     * @return array
     */ 
    public function getNaselja()
    {
        return $this->naselja;
    }

    /**
     * @param array $nizNaselja
     * @return  self
     */ 
    public function setNaselja(array $nizNaselja)
    {
        $naselja = [];
        $opstine = [];
        $okruzi  = [];

        foreach ($nizNaselja as $nizNaselje) {
            if (count($nizNaselje) < 4) {
                //naselje mora da ima 4 clana
                continue;
            }
            
            $naselje = [
                'naselje'        => isset($nizNaselje['naselje'])        ? $nizNaselje['naselje']        : $nizNaselje[0],
                'postanski_broj' => isset($nizNaselje['postanski_broj']) ? $nizNaselje['postanski_broj'] : $nizNaselje[1],
                'okrug'          => isset($nizNaselje['okrug'])          ? $nizNaselje['okrug']          : $nizNaselje[2],
                'opstina'        => isset($nizNaselje['opstina'])        ? $nizNaselje['opstina']        : $nizNaselje[3],
            ];

            if (
                (empty($naselje['naselje']) && !empty($naselje['opstina'])) //prazno je naselje a nije prazna opstina znaci to je opstina
                || $naselje['naselje'] == $naselje['opstina'] //naselje se zove isto kao opstina znaci to je opstina
            ) {
                $opstine[] = [
                    'postanski_broj' => $naselje['postanski_broj'],
                    'okrug'        => $naselje['okrug'],
                    'opstina'        => $naselje['opstina'],
                ];
            }

            if (!isset($okruzi[mb_strtolower($naselje['okrug'])])) {
                $okruzi[mb_strtolower($naselje['okrug'])] = $naselje['okrug'];
            }

            if (!empty($naselje['naselje'])) {
                $naselja[] = $naselje;
            }
        }
        
        usort($naselja, function ($naselje1, $naselje2) {
            return strcmp($naselje1['naselje'], $naselje2['naselje']);
        });

        usort($opstine, function ($opstina1, $opstina2) {
            return strcmp($opstina1['opstina'], $opstina2['opstina']);
        });

        usort($okruzi, function ($okrug1, $okrug2) {
            return strcmp($okrug1, $okrug2);
        });

        $this->naselja = $naselja;
        $this->opstine = array_values($opstine);
        $this->okruzi = array_values($okruzi);

        return $this;
    }

    /**
     * Get the value of lang
     */ 
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param string $lang
     * @return  self
     */ 
    public function setLang(string $lang)
    {
        if ($this->lang == $lang) {
            return $this;
        }

        $nizNaselja = $this->loadNizNaselja($lang);
        $this->setNaselja($nizNaselja);

        $this->lang = $lang;
    }

    /**
     * Ucitava se niz iz fajla sa nizom naselja na osnovu jezika $lang
     * @param string $lang
     * @return array
     */
    protected function loadNizNaselja(string $lang)
    {
        $bazaFile = __DIR__ . '/../data/naselja.' . $lang . '.php';

        if (!is_file($bazaFile)) {
            throw new \RuntimeException('Nije moguce ucitati fajl sa bazom naselja: ' . $bazaFile);
        }

        $nizNaselja = include $bazaFile;

        if (!is_array($nizNaselja)) {
            throw new \RuntimeException('Ucitani podaci nisu PHP niz, iz fajla: ' . $bazaFile);
        }

        return $nizNaselja;
    }
}