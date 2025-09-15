<?php

use Carbon\Carbon;

if (! function_exists('formatDatetime')) {
    /**
     * Format datetime string sesuai kebutuhan.
     *
     * @param  string|null  $datetime
     * @param  string  $type  ('date', 'datetime', 'time', 'daytime')
     * @param  string|null  $datetime2
     * @return string
     */
    function formatDatetime(?string $datetime, string $type = 'datetime', ?string $datetime2 = null): string
    {
        if (empty($datetime)) {
            return '-';
        }

        try {
            $carbon = Carbon::parse($datetime);

            // jika ada datetime2 (range waktu)
            if (!empty($datetime2)) {
                $carbon2 = Carbon::parse($datetime2);

                switch ($type) {
                    case 'date':
                        $left  = $carbon->format('d-m-Y');
                        $right = $carbon2->format('d-m-Y');

                        // jika sama, kembalikan satu tanggal; else range
                        return $left === $right ? $left : ($left . ' - ' . $right);

                    case 'time':
                        $left  = $carbon->format('H:i');
                        $right = $carbon2->format('H:i');

                        return $left === $right ? $left : ($left . ' - ' . $right);

                    case 'day':
                        // gunakan localized day + month
                        if ($carbon->isSameDay($carbon2)) {
                            // Jumat, 12 September 2025
                            return $carbon->translatedFormat('l, d F Y');
                        } else {
                            // Kamis, 11 September 2025 - Jumat, 12 September 2025
                            return $carbon->translatedFormat('l, d F Y');
                        }

                    case 'daytime':
                        // gunakan localized day + month
                        if ($carbon->isSameDay($carbon2)) {
                            // Jumat, 12 September 2025 09:00 - 10:00
                            return $carbon->translatedFormat('l, d F Y H:i') . ' - ' . $carbon2->format('H:i');
                        } else {
                            // Kamis, 11 September 2025 09:00 - Jumat, 12 September 2025 10:00
                            return $carbon->translatedFormat('l, d F Y H:i') . ' - ' . $carbon2->translatedFormat('l, d F Y H:i');
                        }

                    case 'datetime':
                    default:
                        if ($carbon->isSameDay($carbon2)) {
                            // 12-09-2025 09:00 - 10:00
                            return $carbon->format('d-m-Y H:i') . ' - ' . $carbon2->format('H:i');
                        } else {
                            // 11-09-2025 09:00 - 12-09-2025 10:00
                            return $carbon->format('d-m-Y H:i') . ' - ' . $carbon2->format('d-m-Y H:i');
                        }
                }
            }

            // format single datetime (tanpa datetime2)
            switch ($type) {
                case 'date':
                    return $carbon->format('d-m-Y');

                case 'time':
                    return $carbon->format('H:i');

                case 'dayt':
                    return $carbon->translatedFormat('l, d F Y');

                case 'daytime':
                    return $carbon->translatedFormat('l, d F Y H:i');

                case 'datetime':
                default:
                    return $carbon->format('d-m-Y H:i');
            }
        } catch (\Exception $e) {
            return '-';
        }
    }
}

if (! function_exists('convert_time_units')) {
    /**
     * Convert time value from one unit to another.
     *
     * Examples:
     *   convert_time_units(120, 'second', 'minute') => 2
     *   convert_time_units(2.5, 'minute', 'second') => 150
     *
     * @param  int|float  $value
     * @param  string     $from      Supported: second|sec|s, minute|min|m, hour|h (easy to extend)
     * @param  string     $to
     * @param  int        $precision Number of decimal places for non-integer results
     * @return int|float
     *
     * @throws \InvalidArgumentException
     */
    function convert_time_units($value, string $from, string $to, int $precision = 2)
    {
        if (!is_numeric($value)) {
            throw new \InvalidArgumentException('Value must be numeric.');
        }

        // normalize unit aliases to canonical keys
        $normalize = function (string $u) {
            $u = strtolower(trim($u));
            $map = [
                's'     => 'second',
                'sec'   => 'second',
                'second' => 'second',

                'm'     => 'minute',
                'min'   => 'minute',
                'minute' => 'minute',

                'h'     => 'hour',
                'hour'  => 'hour',
            ];

            return $map[$u] ?? null;
        };

        $fromKey = $normalize($from);
        $toKey   = $normalize($to);

        if (!$fromKey || !$toKey) {
            throw new \InvalidArgumentException("Unsupported unit. Supported examples: second, minute, hour (and their aliases).");
        }

        // base factors in seconds (easy to add more units)
        $factors = [
            'second' => 1,
            'minute' => 60,
            'hour'   => 3600,
        ];

        if (!isset($factors[$fromKey]) || !isset($factors[$toKey])) {
            throw new \InvalidArgumentException("Conversion for given units is not available.");
        }

        // convert: value_in_seconds = value * factor_from
        // result = value_in_seconds / factor_to
        $result = $value * ($factors[$fromKey] / $factors[$toKey]);

        // round result to precision when it's not whole number
        $rounded = round($result, $precision);

        // if rounded is integer-like, return int for cleanliness
        if (is_numeric($rounded) && floor($rounded) == $rounded) {
            return (int) $rounded;
        }

        return $rounded;
    }
}

if (! function_exists('get_jenis_soal')) {
    function get_jenis_soal($type)
    {
        return match ($type) {
            'multiple_choice' => 'Pilihan Ganda',
            'essay' => 'Esai',
            default => '-',
        };
    }
}
