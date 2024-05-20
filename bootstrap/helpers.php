<?php

function formatDate($dateString, $format = 'Y-m-d')
{
    $date = new DateTime($dateString);
    return $date->format($format);
}

function formatMoney($amount)
{
    return 'Rp. ' . number_format($amount, 2, ',', '.');
}

function formatDatetime($datetime)
{
    return date('H:i:s d-m-Y', strtotime($datetime));
}
