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