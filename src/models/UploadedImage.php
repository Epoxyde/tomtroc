<?php

class UploadedImage
{
    public static function removeIfUnused(PDO $db, string $type, ?string $filename): void
    {
        $sources = [
            'books' => ['books', 'image'],
            'avatars' => ['users', 'avatar'],
        ];

        if (
            !isset($sources[$type]) ||
            $filename === null ||
            $filename === '' ||
            strpbrk($filename, "/\\:\0") !== false ||
            !in_array(strtolower(pathinfo($filename, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'webp'], true)
        ) {
            return;
        }

        [$table, $column] = $sources[$type];

        try {
            $statement = $db->prepare("SELECT 1 FROM $table WHERE $column = :filename LIMIT 1");
            $statement->execute(['filename' => $filename]);

            if ($statement->fetchColumn() !== false) {
                return;
            }

            $directory = realpath(__DIR__ . '/../../public/uploads/' . $type);
            if ($directory === false) {
                return;
            }

            $candidate = $directory . DIRECTORY_SEPARATOR . $filename;
            $path = realpath($candidate);

            // Ne jamais suivre un lien ou sortir du dossier des images.
            if (
                $path === false ||
                is_link($candidate) ||
                dirname($path) !== $directory ||
                !is_file($path)
            ) {
                return;
            }

            if (!@unlink($path)) {
                error_log('Impossible de supprimer une image inutilisee dans uploads/' . $type);
            }
        } catch (PDOException $exception) {
            // Conserver le fichier si la verification en base echoue.
            error_log('Verification des images inutilisees impossible : ' . $exception->getMessage());
        }
    }
}
