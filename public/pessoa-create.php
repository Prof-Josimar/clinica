<?php
// pessoa-create.php
$content = "
<div class='card shadow'>
    <div class='card-header bg-primary text-white'>
        <h4>Cadastrar Pessoa</h4>
    </div>
    <div class='card-body'>
        <form action='pessoa-cadastrar.php' method='post'>

            <!-- NOME -->
            <div class='mb-3'>
                <label class='form-label'> Nome </label>
                <input type='text' name='nome' class='form-control' maxlength='100' required autofocus placeholder='Digite seu nome' autofocus>
            </div>
            <!-- TELEFONE -->
            <div class='mb-3'>
                <label class='form-label'> Telefone </label>
                <input type='text' name='telefone' class='form-control' maxlength='15' placeholder='(21) 99999-9999'>
            </div>
            <!-- CPF -->
            <div class='mb-3'>
                <label class='form-label'> CPF </label>
                <input type='text' name='cpf' class='form-control' maxlength='11' required placeholder='XXX-XXX-XXX-XX'>
            </div>
            <!-- ENDEREÇO -->
            <div class='mb-3'>
                <label class='form-label'> Endereço </label>
                <textarea name='endereco' class='form-control' rows='3' maxlength='255'>Rua Sobe e Desce chega no fim desaparece</textarea>
            </div>
            <!-- BOTÕES -->
            <div class='d-flex justify-content-start gap-3'>
                <button type='submit' class='btn btn-success'>Salvar</button>
                <button type='reset' class='btn btn-secondary'>Limpar</button>
            </div>


        </form>
    </div>
</div>

";
include "layout.php";
