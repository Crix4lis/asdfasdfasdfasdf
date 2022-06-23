<?php

namespace App\Entity;

use App\Exception\NotACharacterException;

abstract class Characters
{
    /** @var array|string[] */
    protected array $characters;

    public function __construct(string ...$letters)
    {
        $toLower = [];
        foreach ($letters as $letter) {
            self::assertIsCharacter($letter);

            $toLower = strtolower($letter);
        }

        $this->characters = $toLower;
    }

    public static function initiate(): self
    {
        return new static();
    }

    public function appendCharacter(string $char): void
    {
        Characters::assertIsCharacter($char);
        $this->characters[] = $char;
    }

    /**
     * @param string $character
     * @return bool
     *
     * @throws NotACharacterException
     */
    public function alreadyTried(string $character): bool
    {
        self::assertIsCharacter($character);

        $character = strtolower($character);

        return in_array($character, $this->characters);
    }

    public function asArray(): array
    {
        return $this->characters;
    }

    /**
     * @throws NotACharacterException
     */
    public static function assertIsCharacter(string $character): void
    {
        if ((strlen($character) !== 1) || is_numeric($character)) {
            throw new NotACharacterException();
        }
    }
}
