#!/usr/bin/env bash

set -Eeuo pipefail

project_root="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$project_root"

mkdir -p backups/database

timestamp="$(date +%Y%m%d-%H%M%S)"
output="backups/database/wordpress-${timestamp}.sql.gz"

docker compose exec -T db sh -lc '
mariadb-dump \
  --user=root \
  --password="$MARIADB_ROOT_PASSWORD" \
  --single-transaction \
  --routines \
  --triggers \
  --events \
  --default-character-set=utf8mb4 \
  "$MARIADB_DATABASE"
' | gzip > "$output"

test -s "$output"

echo "Database exported to: $output"
