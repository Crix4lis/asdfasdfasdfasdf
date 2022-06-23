<?php

namespace App\ValueObject;

use App\Entity\Characters;
use App\Entity\CharactersGuessed;
use App\Exception\NotACharacterException;
use App\Exception\WordCannotBeEmptyException;

final class Word implements \Stringable
{
    private readonly string $originalWord;
    private readonly array $asArray;

    /**
     * @throws WordCannotBeEmptyException
     */
    public function __construct(string $word)
    {
        if (empty($word)) {
            throw new WordCannotBeEmptyException();
        }

        $word = strtolower($word);
        $this->asArray = str_split($word);
        $this->originalWord = $word;
    }

    public function __toString(): string
    {
        return $this->originalWord;
    }

    public function toArray(): array
    {
        return $this->asArray;
    }

    /**
     * @throws NotACharacterException
     */
    public function containsCharacter(string $character): bool
    {
        Characters::assertIsCharacter($character);

        return str_contains($this->originalWord, $character);
    }

    public function isWordGuessed(CharactersGuessed $guessed): bool
    {
        $currentWord = array_values(array_unique($this->asArray));
        $guessedWord = array_values(array_unique($guessed->asArray()));

        return $currentWord == $guessedWord;
    }


}
