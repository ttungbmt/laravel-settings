<?php

namespace Spatie\LaravelSettings\SettingsCasts;

use RuntimeException;

/**
 * When renaming this class, update the suggestion in composer.json too
 */
class SpatieEnumCast implements SettingsCast
{
    protected string $type;

    public function __construct(?string $type)
    {
        $this->type = $this->ensureEnumExists($type);
    }

    public function get($payload)
    {
        if ($payload === '' || $payload === null) {
            return null;
        }

        return $this->type::make($payload);
    }

    /**
     * @param \Spatie\Enum\Enum $payload
     *
     * @return int|string
     */
    public function set($payload)
    {
        return $payload->jsonSerialize();
    }

    protected function ensureEnumExists(?string $type): string
    {
        if ($type === null) {
            throw new RuntimeException('Cannot create an Enum cast because no Enum class was given');
        }

        if (! class_exists($type)) {
            throw new RuntimeException("Cannot create an Enum cast for `{$type}` because the Enum does not exist");
        }

        return $type;
    }
}
