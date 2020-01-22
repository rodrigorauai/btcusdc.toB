## API BtcUsdc

Solução para conversão de BTC para USDCoin, utilizando api do Coinbase como referência

## Operação cron no servidor

Entrar no arquivo de cron: crontab -e
Para rodar os commands, é necessário adicionar ao arquivo: * * * * * /usr/bin/php-7.2 /var/www/html/btcusdc.to/artisan schedule:run >> /dev/null 2>&1

## Rotas da API
