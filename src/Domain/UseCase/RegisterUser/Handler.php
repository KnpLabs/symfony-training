<?php

declare(strict_types=1);

namespace Domain\UseCase\RegisterUser;

use Domain\Collection\UsersCollection;
use Domain\Exception\UserAlreadyExistsException;
use Domain\Model\User;

class Handler
{
    public function __construct(
        private UsersCollection $usersCollection
    ) {
    }

    public function __invoke(Input $input): Output
    {
        $existingUser = $this->usersCollection->findByEmail($input->email);

        if (null !== $existingUser) {
            throw new UserAlreadyExistsException($input->email);
        }

        $user = new User(
            email: $input->email,
        );

        $user->setPlainPassword($input->password);

        $this->usersCollection->add($user);

        return new Output(user: $user);
    }
}
