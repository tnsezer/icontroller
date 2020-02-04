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
     * @return \DateTime
     */
    public function getDateTime(): \DateTime
    {
        return $this->dateTime;
    }

    /**
     * @param int $month
     * @return $this
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
     * @return $this
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
     * @return \DateTime
     */
    public function getLastWeekDayOfMonth(): \DateTime
    {
        $this->dateTime->modify("last day of this month");
        return $this->dateTime;
    }

    public function getLastFridayOfMonth(): \DateTime
    {
        $this->dateTime->modify("last Friday of this month");
        return $this->dateTime;
    }

    /**
     * @return \DateTime
     */
    public function get15thOfMonth(): \DateTime
    {
        $this->setDay(15);
        return $this->dateTime;
    }

    public function getWednesdayAfter15thOfMonth(): \DateTime
    {
        $this->dateTime->modify("third Wednesday of this month");
        return $this->dateTime;
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