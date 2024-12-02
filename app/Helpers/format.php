<?php
function formatTitle($value = null)
{
    if (is_array($value)) {
        return implode(" - ", $value);
    }

    return $value;
}
function number_format_short($n, $precision = 1)
{
    if ($n < 900) {
        // 0 - 900
        $n_format = number_format($n, $precision);
        $suffix = '';
    } else if ($n < 900000) {
        // 0.9k-850k
        $n_format = number_format($n / 1000, $precision);
        $suffix = 'K';
    } else if ($n < 900000000) {
        // 0.9m-850m
        $n_format = number_format($n / 1000000, $precision);
        $suffix = 'M';
    } else if ($n < 900000000000) {
        // 0.9b-850b
        $n_format = number_format($n / 1000000000, $precision);
        $suffix = 'B';
    } else {
        // 0.9t+
        $n_format = number_format($n / 1000000000000, $precision);
        $suffix = 'T';
    }
    if ($precision > 0) {
        $dotzero = '.' . str_repeat('0', $precision);
        $n_format = str_replace($dotzero, '', $n_format);
    }

    return $n_format . $suffix;
}
function realName($username, $first = null, $last = null, $fullname = null)
{
    if ($fullname) {
        if ($first && $last) {
            return $first . ' ' . $last;
        } else {
            return $username;
        }
    }
    if ($first && $last) {
        return $first . ' ' . $last;
    } elseif ($first) {
        return $first;
    } elseif ($last) {
        return $last;
    } elseif ($username) {
        return $username;
    }
}
?>
