/*
 * Copyright (c) 2022, Kinal.co, Inc. All Rights Reserved.
 * Internal use only.
 */

CREATE
DATABASE IF NOT EXISTS kg_kinal;
CREATE
USER IF NOT EXISTS 'kinal'@'%' IDENTIFIED BY '123Z@';
GRANT ALL PRIVILEGES ON kg_kinal.* To
'kinal'@'%';

CREATE
DATABASE IF NOT EXISTS kg_pkm;
CREATE
USER IF NOT EXISTS 'kinal'@'%' IDENTIFIED BY '123Z@';
GRANT ALL PRIVILEGES ON kg_pkm.* To
'kinal'@'%';


FLUSH
PRIVILEGES;
