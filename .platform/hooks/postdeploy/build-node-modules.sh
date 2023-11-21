pm2 stop accommo-app
cd /var/www/html/frontend/
rm -rf node_modules
npm install
cd ~
pm2 restart accommo-app
