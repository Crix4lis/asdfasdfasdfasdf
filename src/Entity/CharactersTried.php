<?php

namespace App\Entity;

use App\Exception\NotACharacterException;

class CharactersTried extends Characters
{
    /**
     * @param string $character
     * @return bool
     *
     * @throws NotACharacterException
     */
    public function alreadyTried(string $character): bool
    {
        if (strlen($character) !== 1) {
            throw new NotACharacterException();
        }
        $character = strtolower($character);

        return in_array($character, $this->characters);
    }
}
