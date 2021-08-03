<?php

namespace Khill\Duration;

class Duration
{
    public $days;
    public $hours;
    public $minutes;
    public $seconds;

    public $hoursPerDay;

    private $output;
    private $daysRegex;
    private $hoursRegex;
    private $minutesRegex;
    private $secondsRegex;


    /**
     * Duration constructor.
     *
     * @param null $duration
     */
    public function __construct($duration = null, $hoursPerDay = 24)
    {
        $this->days    = 0;
        $this->hours   = 0;
        $this->minutes = 0;
        $this->seconds = 0;

        $this->output       = '';
        $this->daysRegex    = '/([0-9]{1,2})\s?(?:d|D)/';
        $this->hoursRegex   = '/([0-9]{1,2})\s?(?:h|H)/';
        $this->minutesRegex = '/([0-9]{1,2})\s?(?:m|M)/';
        $this->secondsRegex = '/([0-9]{1,2})\s?(?:s|S)/';

        $this->hoursPerDay = $hoursPerDay;

        if (! is_null($duration)) {
            $this->parse($duration);
        }
    }

    /**
     * Attempt to parse one of the forms of duration.
     *
     * @param  int|string $duration A string or number, representing a duration
     * @return self|bool returns the Duration object if successful, otherwise false
     */
    public function parse($duration)
    {
        $this->reset();

        if (is_numeric($duration)) {
            $this->seconds = (int) $duration;

            if ($this->seconds >= 60) {
                $this->minutes = (int) floor($this->seconds / 60);
                $this->seconds = (int) ($this->seconds - ($this->minutes * 60));
            }

            if ($this->minutes >= 60) {
                $this->hours   = (int) floor($this->minutes / 60);
                $this->minutes = (int) ($this->minutes - ($this->hours * 60));
            }

            if ($this->hours >= $this->hoursPerDay) {
                $this->days   = (int) floor($this->hours / $this->hoursPerDay);
                $this->hours = (int) ($this->hours - ($this->days * $this->hoursPerDay));
            }

            return $this;
        } else if (preg_match('/\:/', $duration)) {
            $parts = explode(':', $duration);

            if (count($parts) == 2) {
                $this->minutes = (int) $parts[0];
                $this->seconds = (int) $parts[1];
            } else if (count($parts) == 3) {
                $this->hours   = (int) $parts[0];
                $this->minutes = (int) $parts[1];
                $this->seconds = (int) $parts[2];
            }

            return $this;
        } else if (preg_match($this->daysRegex, $duration) ||
                   preg_match($this->hoursRegex, $duration) ||
                   preg_match($this->minutesRegex, $duration) ||
                   preg_match($this->secondsRegex, $duration))
        {

            if (preg_match($this->daysRegex, $duration, $matches)) {
                $this->days = (int) $matches[1];
            }

            if (preg_match($this->hoursRegex, $duration, $matches)) {
                $this->hours = (int) $matches[1];
            }

            if (preg_match($this->minutesRegex, $duration, $matches)) {
                $this->minutes = (int) $matches[1];
            }

            if (preg_match($this->secondsRegex, $duration, $matches)) {
                $this->seconds = (int) $matches[1];
            }

            return $this;
        } else {
            return false;
        }
    }

    /**
     * Returns the duration as an amount of seconds.
     *
     * For example, one hour and 42 minutes would be "6120"
     *
     * @param  int|string $duration A string or number, representing a duration
     * @return int
     */
    public function toSeconds($duration = null)
    {
        if (! is_null($duration)) {
            $this->parse($duration);
        }

        $this->output = ($this->days * $this->hoursPerDay * 60 * 60) + ($this->hours * 60 * 60) + ($this->minutes * 60) + $this->seconds;

        return (int) $this->output();
    }

    /**
     * Returns the duration as an amount of seconds.
     *
     * For example, one hour and 42 minutes would be "102" minutes
     *
     * @param  int|string $duration A string or number, representing a duration
     * @param  boolean $roundToInteger Should the number be rounded and returned as integer
     * @return int
     */
    public function toMinutes($duration = null, $roundToInteger = false)
    {
        if (! is_null($duration)) {
            $this->parse($duration);
        }

        $this->output = ($this->days * $this->hoursPerDay * 60 * 60) + ($this->hours * 60 * 60) + ($this->minutes * 60) + $this->seconds;
        $result = intval($this->output()) / 60;

        return $roundToInteger ? intval(round($result, 0)) : $result;
    }

    /**
     * Returns the duration as a colon formatted string
     *
     * For example, one hour and 42 minutes would be "1:43"
     *
     * @param  int|string $duration A string or number, representing a duration
     * @return string
     */
    public function formatted($duration = null)
    {

        if (! is_null($duration)) {
            $this->parse($duration);
        }

        $hours = $this->hours + ($this->days * $this->hoursPerDay);

        if ($this->seconds > 0)  {
            if ($this->seconds <= 9 && ($this->minutes > 0 || $hours > 0)) {
                $this->output .= '0' . $this->seconds;
            } else {
                $this->output .= $this->seconds;
            }
        } else {
            if ($this->minutes > 0 || $hours > 0) {
                $this->output = '00';
            }
        }

        if ($this->minutes > 0) {
            if ($this->minutes <= 9 && $hours > 0) {
                $this->output = '0' . $this->minutes . ':' . $this->output;
            } else {
                $this->output = $this->minutes . ':' . $this->output;
            }
        } else {
            if ($hours > 0) {
                $this->output = '00' . ':' . $this->output;
            }
        }

        if ($hours > 0) {
            $this->output = $hours . ':' . $this->output;
        }

        return $this->output();
    }

    /**
     * Returns the duration as a human-readable string.
     *
     * For example, one hour and 42 minutes would be "1h 42m"
     *
     * @param  int|string $duration A string or number, representing a duration
     * @return string
     */
    public function humanize($duration = null)
    {
        if (! is_null($duration)) {
            $this->parse($duration);
        }

        if ($this->seconds > 0) {
            $this->output .= $this->seconds . 's';
        }

        if ($this->minutes > 0) {
            $this->output = $this->minutes . 'm ' . $this->output;
        }

        if ($this->hours > 0) {
            $this->output = $this->hours . 'h ' . $this->output;
        }

        if ($this->days > 0) {
            $this->output = $this->days . 'd ' . $this->output;
        }

        return trim($this->output());
    }

    /**
     * Returns the duration as a human-readable string.
     *
     * For example, one hour and 42 minutes would be "1h 42m"
     *
     * @param  int|string $duration A string or number, representing a duration
     * @return string
     */
    public function humanizec($duration = null)
    {
        if (! is_null($duration)) {
            $this->parse($duration);
        }

        if ($this->seconds > 0) {
            $this->output .= $this->seconds . '秒';
        }

        if ($this->minutes > 0) {
            $this->output = $this->minutes . '分' . $this->output;
        }

        if ($this->hours > 0) {
            $this->output = $this->hours . '小时' . $this->output;
        }

        if ($this->days > 0) {
            $this->output = $this->days . '天' . $this->output;
        }

        return trim($this->output());
    }

    /**
     * Resets the Duration object by clearing the output and values.
     *
     * @access private
     * @return void
     */
    private function reset()
    {
        $this->output  = '';
        $this->seconds = 0;
        $this->minutes = 0;
        $this->hours   = 0;
        $this->days    = 0;
    }

    /**
     * Returns the output of the Duration object and resets.
     *
     * @access private
     * @return string
     */
    private function output()
    {
        $out = $this->output;

        $this->reset();

        return $out;
    }
}

