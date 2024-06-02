# Budget-Tracker application

## Description

Приложение для отслеживания финансовых операций, написанное в процедурном стиле. Обрабатывает данные из *transaction_files* формата **.csv**:

```
Date,Check #,Description,Amount
01/04/2021,7777,Transaction 1,"$150.43"
01/05/2021,,Transaction 2,"$700.25"
01/06/2021,,Transaction 3,"-$1,303.97"
01/07/2021,,Transaction 4,"$46.78"
```

На выходе получаем отформатированную **HTML** страницу:


![result](result.png)

## Build

```
docker build -t budget-tracker-image:latest .
docker run -d -p 8080:80 --name php_app budget-tracker-image:latest
```
