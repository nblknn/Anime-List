<?php

declare (strict_types = 1);

class User {
    private int $id;
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $password;
    private string $salt;
    private ?string $token;
    private bool $isVerified;

    public function __construct(string $firstName, string $lastName, string $email, string $password, string $salt, ?string $token = null, bool $isVerified = false, int $id = 0) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->salt = $salt;
        $this->token = $token;
        $this->isVerified = $isVerified;
    }

    public function getID(): int {
        return $this->id;
    }

    public function getFirstName(): string {
        return $this->firstName;
    }

    public function getLastName(): string {
        return $this->lastName;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getSalt(): string {
        return $this->salt;
    }

    public function getToken(): ?string {
        return $this->token;
    }

    public function getIsVerified(): bool {
        return $this->isVerified;
    }

    public function setID(int $id): User {
        $this->id = $id;
        return $this;
    }

    public function setFirstName(string $firstName): User {
        $this->firstName = $firstName;
        return $this;
    }

    public function setLastName(string $lastName): User {
        $this->lastName = $lastName;
        return $this;
    }

    public function setEmail(string $email): User {
        $this->email = $email;
        return $this;
    }

    public function setPassword(string $password): User {
        $this->password = $password;
        return $this;
    }

    public function setSalt(string $salt): User {
        $this->salt = $salt;
        return $this;
    }

    public function setToken(?string $token): User {
        $this->token = $token;
        return $this;
    }

    public function setIsVerified(bool $isVerified): User {
        $this->isVerified = $isVerified;
        return $this;
    }
}