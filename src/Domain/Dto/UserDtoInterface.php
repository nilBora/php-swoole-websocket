<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Domain\Dto;

interface UserDtoInterface extends NormalizableInterface
{
    /**
     * Return scalar user's uuid.
     */
    public function getUuid(): ?string;
    
    /**
     * Return scalar user's version.
     */
    public function getVersion(): string;
    
    /**
     * Return scalar user's nickname.
     */
    public function getNickname(): ?string;
    
    /**
     * Return scalar user's password.
     */
    public function getPassword(): ?string;
    
    /**
     * Return scalar user's firstname.
     */
    public function getFirstname(): ?string;
    
    /**
     * Return scalar user's lastname.
     */
    public function getLastname(): ?string;
    
    /**
     * Return scalar user's get.
     */
    public function getAge(): ?int;
    
    /**
     * Return scalar user's created date.
     */
    public function getCreatedAt(): ?string;
    
    /**
     * Return scalar user's updated date.
     */
    public function getUpdatedAt(): ?string;
}