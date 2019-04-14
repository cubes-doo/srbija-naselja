<?php

namespace CubesDoo\SrbijaNaselja;

interface BazaInterface
{
    /**
     * Vraca se niz asocijativnih nizova u formatu
     * [
     *      [
     *          'naselje'        => string, // naziv naselja / mesta
     *          'postanski_broj' => int,    // postanski broj naselja / mesta
     *          'okrug'          => string, // naziv okruga
     *          'opstina'        => string, // naziv opstine
     *      ]
     * ]
     * @return array
     */
    public function naselja();

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
    public function naselje($postanskiBroj);

    /**
     * Vraca se niz asocijativnih nizova u formatu
     * [
     *      'postanski_broj' => int,    // postanski broj opstine
     *      'okrug'          => string, // naziv okruga
     *      'opstina'        => string, // naziv opstine
     * ]
     * @return array
     */
    public function opstine();

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
    public function opstina($postanskiBroj);

    /**
     * Vraca se niz stringova sa nazivima okruga po azbucnom redu
     * @return string[]
     */
    public function okruzi();


    /**
     * @param scalar $postanskiBroj
     * @return string|null Ako okrug nije pronadjen NULL, u suprotnom string sa nazivom okruga
     */
    public function okrug($postanskiBroj);

    /**
     * @param string $lang - Setuje se jezik za bazu naselja po kome ce se dobijati rezultati
     */
    public function lang(string $lang);
}