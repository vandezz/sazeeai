#!/bin/bash
#
# Manual Deployment Script — Bypass cPanel Git Queue
# =====================================================
# Cara pakai (jalankan di Terminal cPanel / SSH):
#   cd /home/mxafnahk/repositories/sazeeai
#   bash deploy.sh
#
# Script ini menarik update terbaru dari GitHub lalu meng-copy
# hanya file yang berubah ke direktori produksi. Jauh lebih cepat
# dan andal dibanding cPanel Git UI yang sering stuck di "queued".

set -e  # Berhenti jika ada error

REPO_DIR="/home/mxafnahk/repositories/sazeeai"
PROD_DIR="/home/mxafnahk/sazee.biz.id"

echo "=========================================="
echo "  SazeeAI Manual Deployment"
echo "=========================================="

# 1. Masuk ke direktori repository
cd "$REPO_DIR"

# 2. Tarik update terbaru dari GitHub
echo ""
echo "[1/4] Pulling latest changes from GitHub..."
git fetch origin master
git reset --hard origin/master

# 3. Copy hanya file yang berubah ke produksi (update mode)
echo ""
echo "[2/4] Copying updated files to production..."
/bin/cp -ru "$REPO_DIR/app/"     "$PROD_DIR/app/"
/bin/cp -ru "$REPO_DIR/public/"  "$PROD_DIR/public/"
/bin/cp -f  "$REPO_DIR/composer.json" "$PROD_DIR/composer.json"
/bin/cp -f  "$REPO_DIR/spark"    "$PROD_DIR/spark"

# 4. Jalankan migration database
echo ""
echo "[3/4] Running database migrations..."
/usr/local/bin/php "$PROD_DIR/spark" migrate --no-interaction

# 5. Bersihkan cache
echo ""
echo "[4/4] Clearing cache..."
/usr/local/bin/php "$PROD_DIR/spark" cache:clear || true

echo ""
echo "=========================================="
echo "  ✓ Deployment selesai!"
echo "=========================================="
echo "HEAD Commit: $(git rev-parse --short HEAD)"
