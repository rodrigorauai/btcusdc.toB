## API BtcUsdc

Solução para conversão de BTC para USDCoin, utilizando api do Coinbase como referência

## Operação cron no servidor

Entrar no arquivo de cron: sudo crontab -u apache -e
Para rodar os commands, é necessário adicionar ao arquivo: * * * * * /usr/bin/php /var/www/html/btcusdc.to/artisan schedule:run >> /dev/null 2>&1
