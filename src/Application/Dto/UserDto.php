<?php
namespace Jtrw\Micro\Poc\Rpc\Applicaation\Dto;

use Jtrw\Micro\Poc\Rpc\Domain\Dto\UserDtoInterface;

class UserDto implements UserDtoInterface
{
    private const  VERSION = '0.0.1';
    
    /**
     * Dto version value.
     */
    private string $version;
    
    /**
     * User uuid value.
     */
    private ?string $uuid = null;
    
    /**
     * User name value.
     */
    private ?string $nickname = null;
    
    /**
     * User password value.
     */
    private ?string $password = null;
    
    /**
     * User firstname value.
     */
    private ?string $firstname = null;
    
    /**
     * User lastname value.
     */
    private ?string $lastname = null;
    
    /**
     * User age value.
     */
    private ?int $age = null;
    
    /**
     * User createAt date value.
     */
    private ?string $createdAt = null;
    
    /**
     * User updatedAt date value.
     */
    private ?string $updatedAt = null;
    
    /**
     * @param array $data
     * @return UserDto
     */
    public static function denormalize(array $data)
    {
        $obj = new self();
        $obj->setVersion($data['version']);
        
        if (isset($data['uuid'])) {
            $obj->setUuid($data['uuid']);
        }
        
        if (isset($data['nickname'])) {
            $obj->setNickname($data['nickname']);
        }
        
        if (isset($data['password'])) {
            $obj->setPassword($data['password']);
        }
        
        if (isset($data['firstname'])) {
            $obj->setFirstname($data['firstname']);
        }
        
        if (isset($data['lastname'])) {
            $obj->setLastname($data['lastname']);
        }
        
        if (isset($data['age'])) {
            $obj->setAge((int) $data['age']);
        }
        
        if (isset($data['createdAt'])) {
            $obj->setCreatedAt($data['createdAt']);
        }
        
        if (isset($data['updatedAt'])) {
            $obj->setUpdatedAt($data['updatedAt']);
        }
        
        return $obj;
    }
    
    /**
     * Convert object dto to array.
     *
     * @return mixed[]
     */
    public function normalize(): array
    {
        $data = [
            'version' => $this->getVersion(),
        ];
        
        if (null !== $this->uuid) {
            $data['uuid'] = $this->getUuid();
        }
        
        if (null !== $this->nickname) {
            $data['nickname'] = $this->getNickname();
        }
        
        if (null !== $this->password) {
            $data['password'] = $this->getPassword();
        }
        
        if (null !== $this->firstname) {
            $data['firstname'] = $this->getFirstname();
        }
        
        if (null !== $this->lastname) {
            $data['lastname'] = $this->getLastname();
        }
        
        if (null !== $this->age) {
            $data['age'] = $this->getAge();
        }
        
        if (null !== $this->createdAt) {
            $data['createdAt'] = $this->getCreatedAt();
        }
        
        if (null !== $this->updatedAt) {
            $data['updatedAt'] = $this->getUpdatedAt();
        }
        
        return $data;
    }
    
    /**
     * ProgramDto constructor.
     */
    public function __construct()
    {
        $this->version = self::VERSION;
    }
    
    /**
     * Return uuid value.
     */
    public function getUuid(): ?string
    {
        return $this->uuid;
    }
    
    /**
     * Set uuid value.
     */
    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }
    
    /**
     * Return version value.
     */
    public function getVersion(): string
    {
        return $this->version;
    }
    
    /**
     * Set version value.
     */
    private function setVersion(string $version): void
    {
        $this->version = $version;
    }
    
    /**
     * Return nickname value.
     */
    public function getNickname(): ?string
    {
        return $this->nickname;
    }
    
    /**
     * Set nickname value.
     */
    public function setNickname(?string $nickname): void
    {
        $this->nickname = $nickname;
    }
    
    /**
     * Return password value.
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }
    
    /**
     * Set password value.
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
    
    /**
     * Return name value.
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }
    
    /**
     * Set name value.
     */
    public function setFirstname(?string $firstname): void
    {
        $this->firstname = $firstname;
    }
    
    /**
     * Return lastname value.
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }
    
    /**
     * Set lastname value.
     */
    public function setLastname(?string $lastname): void
    {
        $this->lastname = $lastname;
    }
    
    /**
     * Return age value.
     */
    public function getAge(): ?int
    {
        return $this->age;
    }
    
    /**
     * Set age value.
     */
    public function setAge(int $age): void
    {
        $this->age = $age;
    }
    
    /**
     * Return createdAt value.
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }
    
    /**
     * Set createdAt value.
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
    
    /**
     * Return updatedAt value.
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }
    
    /**
     * Set updatedAt value.
     */
    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}