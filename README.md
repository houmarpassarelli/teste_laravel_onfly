## Sobre o teste técnico

Criar um pedido de viagem: Um pedido deve incluir o ID do pedido, o nome do solicitante, o destino, a data de ida, a data de volta e o status (solicitado, aprovado, cancelado).

Atualizar o status de um pedido de viagem: Possibilitar a atualização do status para "aprovado" ou "cancelado". (nota: o usuário que fez o pedido não pode alterar o status do mesmo)

Consultar um pedido de viagem: Retornar as informações detalhadas de um pedido de viagem com base no ID fornecido.

Listar todos os pedidos de viagem: Retornar todos os pedidos de viagem cadastrados, com a opção de filtrar por status.

Cancelar pedido de viagem após aprovação: Implementar uma lógica de negócios que verifique se é possível cancelar um pedido já aprovado 

Filtragem por período e destino: Adicionar filtros para listar pedidos de viagem por período de tempo (ex: pedidos feitos ou com datas de viagem dentro de uma faixa de datas) e/ou por destino.

Notificação de aprovação ou cancelamento: Sempre que um pedido for aprovado ou cancelado, uma notificação deve ser enviada para o usuário que solicitou o pedido.

## Passos para executar o projeto

### Executar no Docker

Para executar no Docker localmente, basta executar o comando na raiz do projeto. Antes é preciso revisar as configurações do banco de dados no próprio docker-compose.yml. O arquivo está apontando para o arquivo Dockerfile na raíz.

```bash
# Execute o docker localmente 
$ docker-compose up -d
```