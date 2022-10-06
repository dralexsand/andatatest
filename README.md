
Get from git:
```
git clone https://github.com/dralexsand/andatatest.git
cd andatatest
sudo chown -R $USER:$USER .
docker-compose up --build -d
docker exec andatatest_php composer install
```
Migrate and seed:

```
docker exec andatatest_php php command.php db
```

Project run on http://127.0.0.1:8083/



