<?php
declare(strict_types=1);

namespace App;

use App\Entity\Characters;
use App\Entity\CharactersGuessed;
use App\Entity\CharactersTried;
use App\Enum\GameState;
use App\Exception\CharacterAlreadyTriedException;
use App\Exception\DoNotCheatException;
use App\Exception\GameEndedException;
use App\Exception\WordCannotBeEmptyException;
use App\ValueObject\Mistakes;
use App\ValueObject\Word;

final class Game implements GameInterface
{
    private Word $word;
    private Mistakes $mistakes;
    private Characters|CharactersTried $charactersTried;
    private Characters|CharactersGuessed $charactersGuessed;
    private GameState $state;

    /**
     * @param string $word word that player needs to guess
     *
     * @throws WordCannotBeEmptyException if given word is empty
     */
    public function __construct(string $word)
    {
        $this->word = new Word($word);
        $this->mistakes = Mistakes::createNew();
        $this->charactersTried = CharactersTried::initiate();
        $this->charactersGuessed = CharactersGuessed::initiate();
        $this->state = GameState::RUNNING;
    }

    /**
     * @inheritDoc
     */
    public function check(string $letter): bool
    {
        Characters::assertIsCharacter($letter);

        if ($this->state !== GameState::RUNNING) {
            throw new GameEndedException();
        }

        if ($this->charactersTried->alreadyTried($letter)) {
            throw new CharacterAlreadyTriedException();
        }

        if ($this->mistakes->getQuantity() === 0) {
            $this->setGameFailed();
            return false;
        }

        $this->charactersTried->appendCharacter($letter);

        if ($this->word->containsCharacter($letter)) {
            $this->charactersGuessed->appendCharacter($letter);

            if ($this->word->isWordGuessed($this->charactersGuessed)) {
                $this->setGameSuccessfullyFinished();
            }

            return true;
        }

        $this->mistakes = $this->mistakes->subtractOne();

        return false;
    }

    /**
     * @inheritDoc
     */
    public function guessWord(string $word): bool
    {
        $letters = array_unique(str_split($word));

        foreach ($letters as $char) {
            $this->check($char);
        }

        if ($this->state !== GameState::WIN) {
            $this->setGameFailed();

            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function status(): string
    {
        return $this->state->value;
    }

    /**
     * @inheritDoc
     */
    public function isRunning(): bool
    {
        return $this->state === GameState::RUNNING;
    }

    /**
     * @inheritDoc
     */
    public function mistakesLeft(): int
    {
        return $this->mistakes->getQuantity();
    }

    /**
     * @inheritDoc
     */
    public function state(): array
    {
        $state = [];
        foreach ($this->word->toArray() as $char) {
            if (in_array($char, $this->charactersGuessed->asArray())) {
                $state[] = $char;
            } else {
                $state[] = "_";
            }
        }

        return $state;
    }

    /**
     * @inheritDoc
     */
    public function word(): string
    {
        if ($this->state === GameState::RUNNING) {
            throw new DoNotCheatException();
        }

        return $this->word->__toString();
    }

    /**
     * @inheritDoc
     */
    public function alreadyTried(string $letter): bool
    {
        return $this->charactersTried->alreadyTried($letter);
    }

    private function setGameSuccessfullyFinished(): void
    {
        $this->state = GameState::WIN;
    }

    private function setGameFailed(): void
    {
        $this->state = GameState::LOST;
    }
}
