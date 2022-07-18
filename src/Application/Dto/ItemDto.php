<?php

declare(strict_types=1);

namespace Jtrw\Micro\Poc\Rpc\Application\Dto;

use MicroModule\Base\Domain\Exception\SerializationException;

/**
 * Class ItemDto.
 *
 * @SuppressWarnings(PHPMD)
 */
class ItemDto implements NormalizeInterface
{
    private const  VERSION = '0.0.1';

    /**
     * Dto version value.
     *
     * @var string
     */
    private string $version;

    /**
     * Item uuid value.
     *
     * @var string|null
     */
    private ?string $uuid = null;

    /**
     * Item parentId value.
     *
     * @var int|null
     */
    private ?int $parentId = null;

    /**
     * Item name value.
     *
     * @var string|null
     */
    private ?string $name = null;

    /**
     * Item url value.
     *
     * @var string|null
     */
    private ?string $url = null;

    /**
     * Item status value.
     *
     * @var int|null
     */
    private ?int $status = null;

    /**
     * Item createAt date value.
     *
     * @var string|null
     */
    private ?string $createdAt = null;

    /**
     * Item updatedAt date value.
     *
     * @var string|null
     */
    private ?string $updatedAt = null;

    /**
     * Convert array to dto object.
     *
     * @param mixed[] $data
     *
     * @return ItemDto
     */
    public static function denormalize(array $data)
    {
        self::keyExists($data, 'version');
        self::keyExists($data, 'parentId');
        self::keyExists($data, 'name');

        $obj = new self(
            $data['parentId'],
            $data['name']
        );
        $obj->setVersion($data['version']);

        if (isset($data['uuid'])) {
            $obj->setUuid($data['uuid']);
        }

        if (isset($data['url'])) {
            $obj->setUrl($data['url']);
        }

        if (isset($data['status'])) {
            $obj->setStatus($data['status']);
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

        if (null !== $this->name) {
            $data['name'] = $this->getName();
        }

        if (null !== $this->parentId) {
            $data['parentId'] = $this->getParentId();
        }

        if (null !== $this->url) {
            $data['url'] = $this->getUrl();
        }

        if (null !== $this->status) {
            $data['status'] = $this->getStatus();
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
     *
     * @param int    $parentId
     * @param string $name
     */
    public function __construct(int $parentId, string $name)
    {
        $this->version = self::VERSION;
        $this->parentId = $parentId;
        $this->name = $name;
    }

    /**
     * Validate is key exists in array.
     *
     * @param mixed[]    $array
     * @param string|int $key
     *
     * @return bool
     */
    private static function keyExists(array $array, $key): bool
    {
        if (!isset($array[$key])) {
            throw new SerializationException(sprintf('Array does not contain an element with key "%s"', $key));
        }

        return true;
    }

    /**
     * Return uuid value.
     *
     * @return string|null
     */
    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    /**
     * Set uuid value.
     *
     * @param string $uuid
     */
    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * Return version value.
     *
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Set version value.
     *
     * @param string $version
     */
    private function setVersion(string $version): void
    {
        $this->version = $version;
    }

    /**
     * Return name value.
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set name value.
     *
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * Return parentId value.
     *
     * @return int|null
     */
    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    /**
     * Set parentId value.
     *
     * @param int $parentId
     */
    public function setParentId(int $parentId): void
    {
        $this->parentId = $parentId;
    }

    /**
     * Return url value.
     *
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * Set url value.
     *
     * @param string|null $url
     */
    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    /**
     * Return status value.
     *
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * Set status value.
     *
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * Return createdAt value.
     *
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt value.
     *
     * @param string $createdAt
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Return updatedAt value.
     *
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * Set updatedAt value.
     *
     * @param string $updatedAt
     */
    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
