pm2 stop accommo-app
cd /var/www/html/frontend/
sudo rm -rf node_modules
sudo npm install
pm2 restart accommo-app
