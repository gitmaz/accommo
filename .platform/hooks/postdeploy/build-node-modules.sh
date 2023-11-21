pm2 stop accommo-app
cd /var/www/html/frontend/
rm -rf node_modules
npm install
pm2 restart accommo-app
