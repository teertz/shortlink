<?php

namespace Teertz\Shortlink;

class Generator
{
    /**
     * Alphabet that used for generating the shortlink.
     *
     * @var array
     */
    protected $alphabet = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];

    /**
     * Total amount of using letters.
     *
     * @var int
     */
    private $alphabetSize = 0;

    /**
     * Get the initial length of the shortlink.
     *
     * @var int
     */
    protected $initialLength = 3;

    /**
     * Amount of skipped generated options (if initial length !- 0).
     *
     * @var int
     */
    private $skip = 0;

    /**
     * ID for the shortlink.
     *
     * @var int
     */
    protected $id = 1;

    /**
     * User url.
     *
     * @var string
     */
    private $url = '';

    /**
     * Initialization step.
     *
     * @param string $url           URL of the shortlink
     * @param int    $id            ID of the shortlink
     * @param int    $initialLength Initial length of the shortlink
     * @param array  $alphabet      Using alphabet
     */
    public function __construct($url = '', $initialLength = 4, $alphabet = [])
    {
        /* Set the url of the shortlink if defined */
        if ($url) {
            $this->url = $url;
        }

        /* Set minimum length of shortlink if defined */
        if ($initialLength > 0) {
            $this->initialLength = $initialLength;
        }

        /* Set alphabet if defined */
        if (count($alphabet) > 0) {
            $this->alphabet = $alphabet;
        }

        /* Set the length of alphabet */
        $this->alphabetSize = count($this->alphabet);

        /* Configure the amount of links before the set length according to length of shortlink */
        if ($this->initialLength > 1) {
            for ($i = 1; $i < $this->initialLength; ++$i) {
                $this->skip += pow($this->alphabetSize, $i);
            }
        }
    }

    /**
     * Generate shortlink;.
     *
     * @return string Generated shortlink
     */
    public function get($id = 1)
    {
        /* Set id if defined */
        if ($id > 0) {
            $this->id = $id + $this->skip;
        }

        /* Define the used variables */
        $amountOfLetters = 1;
        $position = 0;

        /* Determine the amount of letters in the final shortlink */
        $stop = false;
        while ($stop === false) {
            $position += pow($this->alphabetSize, $amountOfLetters);

            if ($position >= $this->id) {
                $stop = true;
            } else {
                $amountOfLetters++;
            }
        }

        /* Get calculated index value */
        $position = 0;
        for ($i = 1; $i < $amountOfLetters; ++$i) {
            $position += pow($this->alphabetSize, $i);
        }
        $index = $this->id - $position;

        /* Get the first letter */
        $iteration = pow($this->alphabetSize, $amountOfLetters - 1);
        $letter = ceil($index / $iteration);
        $shortlink = $this->alphabet[$letter - 1];
        $nextLetter = $amountOfLetters - 1;

        /* Get another letters */
        for ($i = $nextLetter; $i >= 1; --$i) {
            if ($i > 1) {
                $index = $index - $iteration * ($letter - 1);
                $iteration = pow($this->alphabetSize, $i - 1);
                $letter = ceil($index / $iteration);
                $shortlink .= $this->alphabet[$letter - 1];
            } else {
                $shortlink .= $this->alphabet[($index - $iteration * ($letter - 1)) - 1];
            }
        }

        return $this->url.'/'.$shortlink.'/';
    }
}
