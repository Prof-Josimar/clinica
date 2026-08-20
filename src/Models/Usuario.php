<?php

namespace App\Models;

class Usuario
{
    private ?int $id = null;
    
    private string $senha;
    private string $login;
    private string $perfis;
    // Construtor vazio
    public function __construct(
        string $nome = "",
        string $login = null,
        string $perfis = "",
        
    )

   
