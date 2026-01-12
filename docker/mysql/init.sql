-- Initialize database for Operadora Zacatecas
-- This script runs automatically when the MySQL container is first created

-- Set timezone
SET GLOBAL time_zone = 'America/Mexico_City';

-- Grant all privileges to the operadora user on the database
GRANT ALL PRIVILEGES ON operadora_db.* TO 'operadora'@'%';
FLUSH PRIVILEGES;

-- Set default charset for the database
ALTER DATABASE operadora_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
