## Requisitos da API:
- cadastrar um ponto de venda (PDV), o mesmo deverá conter
  nome_fantasia; cnpj; nome_responsavel; celular_responsavel;
- cadastrar um limite (R$) de vendas para o PDV
- vender os produtos fornecidos por uma outra API. (forneceremos essa
  API para consulta);
- cancelar uma venda (caso de inconsistencia);
- quitar divida do ponto de venda.
  (O sistema funciana de forma PÓS-PAGO, ou seja, o PDV pode vender
  ate o limite configurado, após limite "estourado", para continuar a
  vender, deve se quitar a divida)
  Rota da API para consulta de produtos:
- GET https://api.redeconekta.com.br/mockprodutos/produtos
- response array [{"id": 12312443, "valor": 1000, "descricao": "nome
  do produto"},...]
- id - Inteiro
- valor - Intero - Valor em centavos
- descricao - String