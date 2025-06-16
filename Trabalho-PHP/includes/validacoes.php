<?php
// Arquivo: includes/validacoes.php
// Este arquivo contém funções de validação utilizadas em formulários do sistema

/**
 * Valida os dados de um filme antes de inseri-lo ou atualizá-lo no banco.
 *
 * @param array $filme Dados do filme a serem validados
 * @return bool Retorna true se todos os campos estiverem válidos, false caso contrário
 */
function validar_filme(array $filme): bool {
    // Valida se o nome está preenchido e com tamanho adequado
    if (empty($filme['nome']) || strlen($filme['nome']) > 255) {
        return false;
    }

    // Valida se o nome do diretor está preenchido e com tamanho adequado
    if (empty($filme['diretor']) || strlen($filme['diretor']) > 255) {
        return false;
    }

    // Verifica se o valor é numérico e maior que zero
    if (!is_numeric($filme['valor']) || $filme['valor'] <= 0) {
        return false;
    }

    // Verifica se o estoque é numérico e ao menos 1
    if (!is_numeric($filme['estoque']) || $filme['estoque'] < 1) {
        return false;
    }

    return true;
}
