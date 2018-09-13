Tento projekt je jednoduchoučká chat aplikace napsaná v PHP. Data persistuje v databázi [Redis](https://redis.io/), na kterou se přistupuje pomocí klienta [Predis](https://github.com/nrk/predis). Jsou smazané všechny řádky kódu, které s Redisem pracují. Vaším úkolem je tyto řádky doplnit.

### Instalace

1. `git clone`
2. `composer install`
3. `docker-compose up`
4. V browseru jděte na adresu localhost:12345

### Základní zadání

Doplňte všechny řádky označené jako `(BASIC TASK)` v souborech **src/sendMessage.php** a **src/showMessages.php**. Neupravujte žádné jiné soubory a žádné jiné řádky. Jakmile tak učiníte, chat začne fungovat.

Literatura: http://try.redis.io/

### 1. Rozšířené zadání - High Availability

Upravte/doplňte předpis pro docker tak, aby Redis fungoval s replikací typu master-slave. Dále sestavte vrstvu HA (High Availability) pomocí tří instancí v módu Sentinel a upravte Vaše kódy tak, aby aplikace HA využívala. Nakonec upravte **src/init.php** tak, aby se Predis na Sentinely připojoval.

Literatura:
- https://redis.io/topics/replication
- https://redis.io/topics/sentinel

Příklad spuštění:
`docker-compose up -d --scale sentinel=3`

Příklad výstupu:
`docker ps --format '{{.Names}}'`
redis-cluster_sentinel_3
redis-cluster_sentinel_2
redis-cluster_sentinel_1
redis-cluster_slave_1
redis-cluster_master_1

### 2. Rozšířené zadání - Autentikace

Doplňte všechny řádky označené jako `(EXTENDED TASK)` ve všech souborech v adresáři **src/**. Neupravujte žádné jiné soubory a žádné jiné řádky. Tímto dokážete aplikaci přidat kompletní session management postavený nad Redisem.

Literatura: https://redis.io/topics/twitter-clone

### Odevzdání

Odevzdat úkol můžete dvěma způsoby:
- vytvořením pull requestu do tohoto repozitáře či
- zasláním na emailovou adresu workshop@intraworlds.com

### Řešení

Bude zveřejněno během workshopu ve středu 26. 9. 2018, přijďte :-)
