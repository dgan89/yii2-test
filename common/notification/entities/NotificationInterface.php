<?php

namespace common\notification\entities;

/**
 * Сущность уведомления
 */
interface NotificationInterface
{
    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @return bool
     */
    public function isReadied(): bool;

    /**
     * @return string
     */
    public function getCategory(): string;
}