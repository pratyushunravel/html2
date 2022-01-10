name: Identifier Name
on:
  push:
    branches: [main]

jobs:
  deploy:    
    runs-on: ubuntu-latest
    steps:
      - name: Reset Permissions before deployment
        uses: appleboy/ssh-action@master
        with:
          host: ${{ secrets.SSH_HOST }}
          username: ${{ secrets.SSH_USERNAME }}
          key: ${{ secrets.SSH_KEY }}
          port: 22
          script: |
            sudo chmod -R 755 /var/www/html/html2/
            sudo chown -R username:username /var/www/html/html2/
            sudo setfacl -R -m u:www-data:rwx /var/www/html/html2/

      - uses: actions/checkout@v2      
       
        env:
          HOST: ${{ secrets.SSH_HOST }}
          USERNAME: ${{ secrets.SSH_USERNAME }}
          PORT: 22
          KEY: ${{ secrets.SSH_KEY }}
        with:
          source: "*"
          target: "/var/www/html/html2/"

      - name: Reset Permissions after deployment
        uses: appleboy/ssh-action@master
        with:
          host: ${{ secrets.SSH_HOST }}
          username: ${{ secrets.SSH_USERNAME }}
          key: ${{ secrets.SSH_KEY }}
          port: 22
          script: |
            sudo chmod -R 755 /var/www/html/html2/
            sudo chown -R www-data:www-data /var/www/html/html2/
            sudo setfacl -R -m u:username:rwx /var/www/html/html2/
