<?php
function getCotacao($moeda) {
    $url = "https://economia.awesomeapi.com.br/json/last/" . $moeda;
    
    // Inicializa o cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // Desativa verificação SSL (não recomendado para produção)
    
    // Executa a requisição e armazena a resposta
    $response = curl_exec($ch);
    
    // Verifica se houve erro
    if (curl_errno($ch)) {
        return [
            'error' => 'Erro na requisição: ' . curl_error($ch)
        ];
    }
    
    curl_close($ch);

    // Converte o JSON em array associativo
    $data = json_decode($response, true);
    
    // Verifica se houve erro na conversão ou se não há dados
    if (!$data || empty($data)) {
        return [
            'error' => 'Dados não encontrados para a moeda solicitada.'
        ];
    }
    
    // Extrai o primeiro elemento do array de resposta
    $key = array_key_first($data);
    $cotacao = $data[$key];

    // Retorna os valores formatados
    return [
        'code' => $cotacao['code'] ?? 'N/A',
        'price' => $cotacao['ask'] ?? 'N/A',
        'date' => $cotacao['create_date'] ?? 'N/A'
    ];
}
?>
