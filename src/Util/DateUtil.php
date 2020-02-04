<?php

namespace App\Util;

class DateUtil
{
    /** @var \DateTime $dateTime */
    private $dateTime;

    /**
     * DateUtil constructor.
     * @param string $time
     * @throws \InvalidArgumentException
     */
    public function __construct(string $time = 'now')
    {
        try {
            $this->dateTime = new \DateTime($time);
        } catch (\Exception $e) {
            throw new \InvalidArgumentException();
        }
    }

    /**
     * @param string $format
     * @return string
     */
    public function getDateTime(string $format = 'Y-m-d'): string
    {
        return $this->dateTime->format($format);
    }

    /**
     * @param int $month
     * @return DateUtil
     */
    public function setMonth(int $month): self
    {
        $this->dateTime->setDate(
            $this->dateTime->format('Y'),
            $month,
            $this->dateTime->format('d')
        );

        return $this;
    }

    /**
     * @param int $day
     * @return DateUtil
     */
    public function setDay(int $day): self
    {
        $this->dateTime->setDate(
            $this->dateTime->format('Y'),
            $this->dateTime->format('m'),
            $day
        );

        return $this;
    }

    /**
     * @return DateUtil
     */
    public function getLastWeekDayOfMonth(): self
    {
        $this->dateTime->modify("last day of this month");
        return $this;
    }

    public function getLastFridayOfMonth(): self
    {
        $this->dateTime->modify("last Friday of this month");
        return $this;
    }

    /**
     * @return DateUtil
     */
    public function get15thOfMonth(): self
    {
        $this->setDay(15);
        return $this;
    }

    /**
     * @return DateUtil
     */
    public function getWednesdayAfter15thOfMonth(): self
    {
        $this->dateTime->modify("third Wednesday of this month");
        return $this;
    }

    /**
     * @return string
     */
    public function getNameOfMonth(): string
    {
        return $this->dateTime->format('F');
    }

    /**
     * @return bool
     */
    public function isWeekend(): bool
    {
        return $this->dateTime->format('N') > 5;
    }
}