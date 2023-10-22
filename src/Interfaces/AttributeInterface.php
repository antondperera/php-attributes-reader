<?php

declare(strict_types=1);

namespace AntonDPerera\PHPAttributesReader\Interfaces;

interface AttributeInterface
{
    public function getClass(): string;
    public function getName(): string;
    public function getArguments(): array;
    public function hasArguments(): bool;
}