<?php

namespace App\Utils;

class Formatter
{
    public static function formatCpf(string $cpf): string
    {
        $cpf = preg_replace('/\D/', '', $cpf);
        if (strlen($cpf) === 11) {
            return substr($cpf, 0, 3) . '.' .
                substr($cpf, 3, 3) . '.' .
                substr($cpf, 6, 3) . '-' .
                substr($cpf, 9, 2);
        }
        return $cpf;
    }

    public static function formatTelefone(string $telefone): string
    {
        $telefone = preg_replace('/\D/', '', $telefone);

        if (strlen($telefone) === 11) {
            return '(' . substr($telefone, 0, 2) . ') ' .
                substr($telefone, 2, 5) . '-' .
                substr($telefone, 7, 4);
        } elseif (strlen($telefone) === 10) {
            return '(' . substr($telefone, 0, 2) . ') ' .
                substr($telefone, 2, 4) . '-' .
                substr($telefone, 6, 4);
        }
        return $telefone;
    }
    public static function toUpper(string $texto): string
    {
        // Remove acentos
        $texto = transliterator_transliterate(
            'NFD; [:Nonspacing Mark:] Remove; NFC',
            $texto
        );

        // Converte para maiúsculo
        return mb_strtoupper($texto, 'UTF-8');
    }
}
