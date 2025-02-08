<?php
declare(strict_types=1);

namespace Foo;

use Foo\Exception\CharacterAlreadyTriedException;
use Foo\Exception\DoNotCheatException;
use Foo\Exception\GameEndedException;
use Foo\Exception\NotACharacterException;
use Foo\Exception\WordCannotBeEmptyException;

final class Game implements GameInterface
{

    /**
     * @param string $word word that player needs to guess
     *
     * @throws WordCannotBeEmptyException if given word is empty
     */
    public function __construct(string $word)
    {
        //@TODO: throw WordCannotBeEmpty exception if given word is empty
    }

    /**
     * @inheritDoc
     */
    public function check(string $letter): bool
    {
        /*
         * @TODO: method returns true if letter is found in the word, false otherwise
         *
         * @TODO: throw CharacterAlreadyTriedException if ... character was already.. tried
         * @TODO: throw GameEndedException if game has been already ended
         * @TODO: throw NotACharacterExcpetion if value you tries is not english alfabet letter (case insensitive)
        */
    }

    /**
     * @inheritDoc
     */
    public function guessWord(string $word): bool
    {
        /*
         * @TODO end game and return true if guessed word is correct (case insensitive), false otherwise
         * @TODO throw GameEndedException if game has been ended
         */
    }

    /**
     * @inheritDoc
     */
    public function status(): string
    {
        /*
         * @TODO return status string: 'RUNNING' 'WIN' 'LOST'
         */
    }

    /**
     * @inheritDoc
     */
    public function isRunning(): bool
    {
        //@TODO return true if game has not been ended (where status is "RUNNING")
    }

    /**
     * @inheritDoc
     */
    public function mistakesLeft(): int
    {
        //@TODO return number of mistakes left
    }

    /**
     * @inheritDoc
     */
    public function state(): array
    {
        //@TODO return state of the game as an array as described in GameInterface
    }

    /**
     * @inheritDoc
     */
    public function word(): string
    {
        // @TODO return given word, unless the game is running - in that case throw DoNotCheatException
    }

    /**
     * @inheritDoc
     */
    public function alreadyTried(string $letter): bool
    {
        // @TODO return true if letter was already tried (false otherwise)
    }

}