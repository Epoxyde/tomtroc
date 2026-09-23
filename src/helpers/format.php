<?php

function formatMemberSince(string $createdAt): string
{
    $created = new DateTime($createdAt);
    $now = new DateTime();

    $interval = $created->diff($now);

    if ($interval->y > 0) {
        $years = $interval->y;

        return 'Membre depuis ' . $years . ' '
            . ($years > 1 ? 'ans' : 'an');
    }

    if ($interval->m > 0) {
        $months = $interval->m;

        return 'Membre depuis ' . $months . ' mois';
    }

    if ($interval->d > 0) {
        $days = $interval->d;

        return 'Membre depuis ' . $days . ' '
            . ($days > 1 ? 'jours' : 'jour');
    }

    return "Membre depuis aujourd'hui";
}

/**
 * Formate la date d'un message selon son ancienneté.
 */
function formatMessageDate(string $createdAt): string
{
    $date = new DateTime($createdAt);
    $now = new DateTime();

    if ($date->format('Y-m-d') === $now->format('Y-m-d')) {
        return $date->format('H:i');
    }

    if ($date->format('Y') === $now->format('Y')) {
        return $date->format('d.m H:i');
    }

    return $date->format('d.m.Y H:i');
}